<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        // Pon las mismas reglas que tenías en el CreateRequest
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'categories' => 'nullable|array',
            'category.*' => 'EXISTS:categories,id',
            'sizes' => 'nullable|array', // Las tallas vienen en formato array
            'sizes.*.name' => 'required_with:sizes|string|max:50', // Valida el nombre dentro del array
            'sizes.*.stock' => 'required_with:sizes|integer|min:0', // Valida el stock dentro del array'
            // 'status' => 'required|in:draft,published', // posibilidad de campo
        ];
    }
}
