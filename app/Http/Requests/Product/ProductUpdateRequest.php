<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'sometimes|string|unique:products,sku,' . $this->route('id'),
            'stock' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'project_name.required' => 'Ürün adı zorunludur.',
            'sku.required' => 'Stok kodu zorunludur.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat sayısal bir değer olmalıdır.',
            'price.min' => 'Fiyat en az :min olmalıdır.',
            'price.max' => 'Fiyat en fazla :max olabilir.',
            'category_id.exists' => 'Kategori bulunamadı.',
        ];
    }
}
