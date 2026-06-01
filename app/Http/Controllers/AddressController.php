<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Services\AddressService;
use App\Services\UsersService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
        protected AddressService $service,
        protected UsersService $usersService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = $this->service->getAll();
        return view('addresses.listAddresses', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users = $this->usersService->getAll();
        $userId = $request->input('user_id');
        return view('addresses.createAddress', compact('users', 'userId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        try {
            $authUser = auth()->user();
            $userId = $authUser->roles->contains('name', 'admin')
                ? $request->input('user_id', $authUser->id)
                : $authUser->id;
            $user = $this->usersService->get($userId);
            $this->service->create($user, $request->validated());

            return redirect("/addresses/user/{$user->username}")->with('msg', 'Dirección creada con éxito');
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }

    }

    /**
     * Display the specified resource by user ID (hidden in POST).
     */
    public function show(Request $request)
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                return redirect('/addresses');
            }

            $user = $this->usersService->get($userId);
            $addresses = $user->addresses;
            
            return view('addresses.listAddresses', compact('addresses', 'userId'));
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            return view('addresses.listAddresses', ['addresses' => [], 'msg' => $msg]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
{
    try {
        
        $address = $this->service->get($id);
        $authUser = auth()->user();

        
        if ($authUser->roles->contains('id', 2) && $address->user_id !== $authUser->id) {
            abort(403, 'Acceso denegado: No puedes editar una dirección que no te pertenece.');
        }

        
        $users = $this->usersService->getAll();

        return view('addresses.editAddress', compact('address', 'users'));

    } catch (\Throwable $e) {
        return redirect()->route('addresses.index')
                         ->with('msg', 'No se pudo cargar la dirección: ' . $e->getMessage());
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        try {
            $user = $this->usersService->get($address->user_id);

            $this->service->update($user, $address, $request->validated());
        } catch (\Throwable $e) {
            dd([
                'Mensaje' => $e->getMessage(),
                'Archivo' => $e->getFile(),
                'Linea'   => $e->getLine(),
                'Datos_Enviados' => $request->all()
            ]);
        }

        $redirectTo = $request->input('redirect_to') ?: route('addresses.show', ['username' => $user->username]);

        return redirect($redirectTo)->with('msg', 'Dirección actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $address = $this->service->get($id);
            $user = $this->usersService->get($address->user_id);
            $this->service->delete($address);
        } catch (\Throwable $e) {
            dd([
                'Mensaje' => $e->getMessage(),
                'Archivo' => $e->getFile(),
                'Linea'   => $e->getLine(),
            ]);
        }

        return redirect("/addresses/user/{$user->username}")->with('msg', 'Dirección eliminada con éxito');
    }
}
