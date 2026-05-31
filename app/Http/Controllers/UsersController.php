<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\AddFavoritesRequest;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
use App\Models\FavoriteList;
use App\Models\Product;
use App\Services\RolesService;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Services\UsersService;
use Hash;

class UsersController extends Controller
{
    public function __construct(protected UsersService $userService, protected RolesService $rolesService){

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAll();
        return view('users.listUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->rolesService->getAll();
        return view('users.createUser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        try {
            $newUser = new User;
            $newUser -> username = $request -> username;
            $newUser -> name = $request -> name;
            $newUser -> email = $request -> email;
            $newUser -> password = User::encryptPassword($request -> password);
            $newUser -> phone = $request -> phone;
            $this->userService->store($newUser);

            $newUser->roles()->attach($request->role);
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username)
{
    try {
        
        $user = $this->userService->getUserByUsername($username);
        $authUser = auth()->user();

        if ($authUser->roles->contains('id', 2) && $authUser->username !== $username) {
            abort(403, 'Acceso denegado: No puedes ver el perfil de otro usuario.');
        }

        if ($authUser->roles->contains('id', 1)) {
            $users = [$user]; 
            return view('users.listUsers', compact('users'));
        }

        return view('users.profile', compact('user'));

    } catch (Exception $e) {
        return redirect()->route('home')->with('error', 'No se pudo cargar el perfil: ' . $e->getMessage());
    }
}

    public function show_by_username(string $username)
    {
        $user = $this->userService->getUserByUsername($username);
        if (!$user) {
            return view('users.listUsers', [
                'users' => [], 
                'msg' => "Usuario no encontrado"
            ]);
        }

        $users = [$user];
        return view('users.listUsers', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $username)
    {
        try {
            $user = $this->userService->getUserByUsername($username);
            $roles = $this->rolesService->getAll();
            return view('users.editUser', compact('user', 'roles'));
        } catch (Exception $e) {
            return view('users.listUsers', ['users' => [], 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, string $id)
    {   
        try {
            $user = $this->userService->get($id);
            $authUser = auth()->user();

            // SEGURIDAD (IDOR): ¿es este usuario el dueño del perfil o un admin?
            if (!$authUser->roles->contains('id', 1) && $authUser->id !== $user->id) {
                abort(403, 'No tienes permiso para modificar este perfil.');
            }

            $user->username = $request->username;
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // toque de ciberseguridad ;) (Escalada de Privilegios): 
            // Solo cogemos el rol del formulario si quien está ejecutando la acción es un ADMIN
            $roleToUpdate = $authUser->roles->contains('id', 1) ? $request->role : null;
            
            $this->userService->update($user, $roleToUpdate);

        } catch (\Throwable $e) {
            // es mejor registrar en el Log y no hacer un dd() que detenga la app
            \Log::error('Error actualizando usuario: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el perfil.');
        }

        if ($authUser->roles->contains('id', 1)) {
            return redirect()->route('users.index')->with('msg', 'Usuario actualizado con éxito');
        } else {
            return redirect()->route('users.show', $user->username)->with('msg', 'Perfil actualizado con éxito');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->userService->get($id);
            $this->userService->delete($user);
        } catch (\Throwable $e) {
            dd([
                'Mensaje' => $e->getMessage(),
                'Archivo' => $e->getFile(),
                'Linea'   => $e->getLine(),
            ]);
        }

        return redirect('/users')->with('msg', 'Usuario eliminado con éxito');
    }

    public function showAddresses(string $username){
        $user = $this->userService->getUserByUsername($username);
    $authUser = auth()->user();
        
        
        
        $addresses = $user->addresses;
        return view('addresses.listAddresses', compact('addresses'));
    }

    public function addFavorites(AddFavoritesRequest $request){
        $this->userService->addFavorites(
            auth()->id(),
            $request->product_id
        );
        return redirect()->back();
    }

    public function showFavorites(){
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus favoritos');
        }
        
        $favoriteList = $user->favoriteList;
        
        if (!$favoriteList || empty($favoriteList->products)) {
            return view('users.favorites', ['products' => []]);
        }
        
        $products = Product::whereIn('id', $favoriteList->products)->get();
        return view('users.favorites', compact('products'));
    }

    public function removeFavorites(Product $product){
        $this->userService->removeFavorites(auth()->id(), $product->id);
        return redirect()->back();
    }
}