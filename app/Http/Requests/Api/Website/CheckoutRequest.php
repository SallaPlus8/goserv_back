<?php

namespace App\Http\Requests\Api\Website;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'carts' => 'required|array',
            'carts.*.cart_id' => 'required|exists:carts,id',
            // 'cart.*.product_color_id' => 'required|exists:product_colors,id',
            // 'cart.*.quantity' => 'required|integer|min:1',
            'coupon_code' => 'nullable|string' // Validate coupon code if provided
        ];
    }
}
