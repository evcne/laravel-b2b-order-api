<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,id',
            'status' => 'required|string|in:pending, approved, shipped, cancelled',
            //'total_price' => 'required|numeric|min:0',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'Belirtilen kullanıcı sistemde bulunamadı.',
            'status.required' => 'Sipariş durumu alanı zorunludur.',
            'status.string' => 'Sipariş durumu metin tipinde olmalıdır.',
            'status.in' => 'Sipariş durumu yalnızca şu değerlerden biri olabilir: pending, approved, shipped, cancelled.',
            'order_items.required' => 'En az bir sipariş kalemi girilmelidir.',
            'order_items.array' => 'Sipariş kalemleri dizi formatında olmalıdır.',
            'order_items.min' => 'En az bir adet sipariş kalemi girilmelidir.',
            'order_items.*.product_id.required' => 'Her sipariş kaleminde ürün ID belirtilmelidir.',
            'order_items.*.product_id.exists' => 'Belirtilen ürün sistemde bulunamadı.',
            'order_items.*.quantity.required' => 'Her sipariş kaleminde adet bilgisi girilmelidir.',
            'order_items.*.quantity.integer' => 'Adet bilgisi tam sayı olmalıdır.',
            'order_items.*.quantity.min' => 'Adet bilgisi en az 1 olmalıdır.',
            'order_items.*.unit_price.required' => 'Her sipariş kaleminde birim fiyat girilmelidir.',
            'order_items.*.unit_price.numeric' => 'Birim fiyat sayısal bir değer olmalıdır.',
            'order_items.*.unit_price.min' => 'Birim fiyat sıfırdan küçük olamaz.',
        ];
    }

}
