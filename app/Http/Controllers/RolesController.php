<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRolesRequest;
use App\Http\Requests\Roles\UpdateRolesRequest;
use App\Models\Role;
use App\Services\RolesService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public function __construct(protected RolesService $service){
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles =  $this->service->getAll();
        return view('roles.listRoles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.createRoles');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolesRequest $request)
    {
        try{
            $newRole = new Role;

            $newRole->name = $request->name;
            $newRole->description = $request->description;

            $this->service->store($newRole);
        }catch(\Throwable $e){
            dd($e->getMessage());
        }
        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $role = $this->service->get($name);
        if(!$role){
            return view('roles.listRoles', [
            'roles' => [], 
            'msg' => "Role no encontrado"
            ]);
        }

        $roles = [$role];
        return view('roles.listRoles', compact('roles'));
    }

    public function edit(string $colum)
    {
        try{
            $role = $this->service->get($colum);
            return view('roles.editRoles', compact('role'));
        }catch(\Throwable $e){
            return view('roles.listRoles', ['roles' => [], 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolesRequest $request, string $colum)
    {
        try {
        $role = $this->service->get($colum);

        $role->name = $request->name;
        $role->description = $request->description;

        $this->service->update($role);

        } catch (\Throwable $e) {
            dd([
            'Mensaje' => $e->getMessage(),
            'Archivo' => $e->getFile(),
            'Linea'   => $e->getLine(),
            'Datos_Enviados' => $request->all()
        ]);
        }

        return redirect('/roles')->with('msg', 'Role actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $colum)
    {
        try {
            $user = $this->service->get($colum);
            $this->service->delete($user);
            
        } catch (\Throwable $e) {
        dd([
        'Mensaje' => $e->getMessage(),
        'Archivo' => $e->getFile(),
        'Linea'   => $e->getLine(),
        ]);
        }

        return redirect('/roles')->with('msg', 'Role eliminado con éxito');
    }
}
