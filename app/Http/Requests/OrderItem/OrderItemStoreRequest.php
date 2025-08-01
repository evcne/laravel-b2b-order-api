<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'    => 'Ürün ID alanı zorunludur.',
            'product_id.exists'      => 'Seçilen ürün mevcut değil.',
            'quantity.required'      => 'Adet alanı zorunludur.',
            'quantity.integer'       => 'Adet sayısı bir tam sayı olmalıdır.',
            'quantity.min'           => 'Adet en az 1 olmalıdır.',
            'unit_price.required'    => 'Birim fiyatı alanı zorunludur.',
            'unit_price.numeric'     => 'Birim fiyatı sayısal bir değer olmalıdır.',
            'unit_price.min'         => 'Birim fiyatı negatif olamaz.',
        ];
    }

}
