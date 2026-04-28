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
            'sizes' => 'nullable|array',
            'sizes.*.name' => 'nullable|string|max:50', // Cambiamos required_with por nullable
            'sizes.*.stock' => 'nullable|integer|min:0', // Cambiamos required_with por nullable
            // 'status' => 'required|in:draft,published', // posibilidad de campo
        ];
    }
}
