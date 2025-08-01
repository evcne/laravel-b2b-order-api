<?php 

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string|in:pending, approved, shipped, cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Sipariş durumu alanı zorunludur.',
            'status.string'   => 'Sipariş durumu metin tipinde olmalıdır.',
            'status.in'       => 'Sipariş durumu yalnızca şunlardan biri olabilir: pending, approved, shipped, cancelled.',
        ];
    }

}
