<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRolesRequest;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
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
            $newUser->username = $request->username;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = Hash::make($request->password);
            $newUser->phone = $request->phone;
            $newUser->address = ''; // Valor temporal hasta ejecutar la migración que elimina el campo
            
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
            $users = [$user];
            return view('users.listUsers', compact('users'));
        } catch (Exception $e) {
            $msg = $e->getMessage();
            return view('users.listUsers', compact('msg'));
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

            $user->username = $request->username;
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $this->userService->update($user, $request->role);

        } catch (\Throwable $e) {
            dd([
                'Mensaje' => $e->getMessage(),
                'Archivo' => $e->getFile(),
                'Linea'   => $e->getLine(),
                'Datos_Enviados' => $request->all()
            ]);
        }

        return redirect('/users')->with('msg', 'Usuario actualizado con éxito');
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
        $addresses = $user->addresses;
        return view('addresses.listAddresses', compact('addresses'));
    }
}