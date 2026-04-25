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
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'phone'      => 'nullable|string|min:9',
                'address' => 'nullable|string|min:18'
            ]);

            $role=Role::find($request->role);
            $newUser = new User;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
