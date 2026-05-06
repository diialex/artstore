<?php

namespace App\Http\Requests\Roles;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRolesRequest extends FormRequest
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

    $roleId = $this->route('role');
        return [
            'name' => [
            'required',
            'string',
            'max:30',
            Rule::unique('roles', 'name')->ignore($roleId)
        ],
            'description' => 'required|string|min:10|max:60'
        ];
    }
}
