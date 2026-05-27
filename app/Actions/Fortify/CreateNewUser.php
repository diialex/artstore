<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use App\Services\UsersService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(protected UsersService $usersService)
    {
    }

    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:20'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = new User([
            'username' => $input['username'],
            'phone'    => $input['phone'],
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => User::encryptPassword($input['password']),
        ]);

        $this->usersService->store($user);

        $userRole = Role::where('name', 'user')->first();
        $this->usersService->update($user, [$userRole->id]);

        return $user;
    }
}
