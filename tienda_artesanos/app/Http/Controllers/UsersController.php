<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
use function PHPUnit\Framework\throwException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('listUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('createUser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{
            $request->validate([
                'username' => 'required|string|max:20',
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'phone'      => 'nullable|string|min:9',
                'address' => 'nullable|string|min:18'
            ]);

            $role=Role::find($request->role);
            $newUser = new User;
            $newUser -> username = $request -> username;
            $newUser -> name = $request -> name;
            $newUser -> email = $request -> email;
            $newUser -> password = Hash::make($request->password);
            $newUser -> phone = $request -> phone;
            $newUser -> address = $request -> address;
            $newUser->saveOrFail();

            if(!$role){
                $newException = new Exception("rol no existe");
                throwException($newException);
            }

            $newUser->roles()->attach($request->role);
            } catch (\Throwable $e) {
                dd($e->getMessage());
            }

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $users = $this->get_user($id);
        }catch(Exception $e){
            $msg = $e->getMessage();
            return view('listUsers', compact('msg'));
        }
        
        return view('listUsers', compact('users'));
    }

    public function show_by_username(string $username)
    {
        $user = User::where('username', $username)->first();
        if(!$user){
            return view('listUsers', [
            'users' => [], 
            'msg' => "Usuario no encontrado"
            ]);
        }

        $users = [$user];
        return view('listUsers', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $user = $this->get_user($id);
            $roles = Role::all();
            return view('editUser', compact('user', 'roles'));
        }catch(Exception $e){
            return view('listUsers', ['users' => [], 'msg' => $e->getMessage()]);
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
    try {
        $user = $this->get_user($id);

        $rules = [
            'username' => 'required|string|max:20',
            'name'     => 'required|string|max:20',
            'email'    => 'required|email|unique:users,email,' . $id, 
            'phone'    => 'nullable|string|min:9',
            'address'  => 'nullable|string|min:18'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules);

        $user->username = $request->username;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->address  = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $role = Role::find($request->role);
        if (!$role) {
            throw new Exception("El rol seleccionado no existe");
        }

        $user->roles()->sync($request->role);

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
            $user = $this->get_user($id);
            $user->delete();
            
        } catch (\Throwable $e) {
        dd([
        'Mensaje' => $e->getMessage(),
        'Archivo' => $e->getFile(),
        'Linea'   => $e->getLine(),
        ]);
        }

        return redirect('/users')->with('msg', 'Usuario eliminado con éxito');
    }

    public function get_user(string $id)
    {
        $user = User::find($id);
        if(!$user){
            throw new Exception("Usuario no existe");
        }
        return $user;
    }
}