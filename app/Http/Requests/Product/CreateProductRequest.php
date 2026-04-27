<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|url',
            'categories' => 'nullable|array',
            'category.*' => 'exists:categories,id',
            'sizes' => 'nullable|array',
            'sizes.*.name' => 'required_with:sizes|string|max:50',
            'sizes.*.stock' => 'required_with:sizes|integer|min:0',
        ];
    }
}
