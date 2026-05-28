<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],                 
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // 1. GUARDAMOS EL RESULTADO EN LA VARIABLE $user EN LUGAR DE HACER RETURN
        $user = User::create([
            'username' => $input['username'],
            'phone' => $input['phone'],      
            'address' => 'Dirección pendiente',  
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // 2. AHORA SÍ, ASIGNAMOS EL ROL
        $user->roles()->attach(2);

        // 3. ENVIAMOS EL CORREO A MAILTRAP
        Mail::raw('¡Hola ' . $user->name . '! Gracias por registrarte en nuestra tienda. Tu cuenta ha sido creada con éxito ya puedes descubrir las últimas novedades y colecciones.', function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('¡Bienvenido a Hanger! :)');
        });

        // 4. RETORNAMOS EL USUARIO AL FINAL DEL TODO
        return $user;
    }
}
