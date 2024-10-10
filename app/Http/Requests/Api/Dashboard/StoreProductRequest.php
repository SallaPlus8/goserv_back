<?php

namespace App\Http\Requests\Api\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

            // 'name.en' => 'nullable|string|max:255',
            // 'name.ar' => 'nullable|string|max:255',
            // 'description.en' => 'nullable|string|max:1000',
            // 'description.ar' => 'nullable|string|max:1000',
            // 'details.en' => 'nullable|string',
            // 'details.ar' => 'nullable|string',
            // 'category_id' => 'nullable|exists:categories,id',
            // 'brand_id' => 'nullable|exists:brands,id',
            // 'weight' => 'nullable|numeric', //grams
            // 'colors' => 'nullable|array',
            // 'colors.*.color_id' => 'nullable|exists:colors,id',
            // 'price' => 'nullable|numeric',
            // 'size_id' => 'nullable|exists:sizes,id',
            // 'colors.*.quantity' => 'nullable|integer|min:1',
            'name.en' => 'nullable|string|max:255',
            'name.ar' => 'nullable|string|max:255',
            'description.en' => 'nullable|string|max:1000',
            'description.ar' => 'nullable|string|max:1000',
            'details.en' => 'nullable|string',
            'details.ar' => 'nullable|string',

            // Category, brand, weight, and other product attributes
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'weight' => 'nullable|numeric', // grams

            // Colors and color-related validations
            'colors' => 'nullable|array',
            'colors.*.color_id' => 'nullable|exists:colors,id', // Color validation
            'colors.*.photos' => 'nullable|array', // Array of photos for each color
            'colors.*.photos.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:10000', // Validate each photo in the array

            // Sizes and size-related validations for each color
            'colors.*.sizes' => 'nullable|array',
            'colors.*.sizes.*.size_id' => 'nullable|exists:sizes,id', // Size validation
            'colors.*.sizes.*.quantity' => 'nullable|integer|min:1', // Minimum quantity of 1
            'colors.*.sizes.*.price' => 'nullable|numeric|min:0', // Validate price
            'colors.*.sizes.*.cost' => 'nullable|numeric|min:0', // Validate cost


        ];

    }
}
            // 'name.en' => 'nullable|string|max:255',
            // 'name.ar' => 'nullable|string|max:255',
            // 'description.en' => 'nullable|string|max:1000',
            // 'description.ar' => 'nullable|string|max:1000',
            // 'details.en' => 'nullable|string',
            // 'details.ar' => 'nullable|string',
            // 'price' => 'nullable|numeric|min:0',
            // 'category_id' => 'nullable|exists:categories,id',
            // 'main_photos' => 'nullable|array',
            // 'main_photos.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:10000', // Validate each photo upload
            // 'is_sold' => 'boolean',
            // 'weight' => 'nullable|numeric|min:0',
            // 'brand_id' => 'nullable|exists:brands,id',
            // 'main_color_quantity' => 'nullable|integer|min:0', // Validate quantity as a non-negative integer
            // 'color_id' => 'nullable|exists:colors,id', // Validate color_id
            // 'colors.*.photos' => 'nullable|array',
            // 'colors.*.photos.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:10000',
