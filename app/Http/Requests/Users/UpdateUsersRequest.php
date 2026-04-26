<?php

namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $password = $this->route('password');
        $id = $this->route('id');
        $rules=[];
        if (trim($password) !== "") {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $rules['username'] = 'required|string|max:20';
        $rules['name'] = 'required|string|max:20';
        $rules['email'] = ['required','email', Rule::unique('users')->ignore($id)];
        $rules['phone'] = 'nullable|string|min:9';
        $rules['address'] = 'nullable|string|min:18';
        
        return $rules;
    }
}
