<?php

namespace App\Http\Requests\Api\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerSecTwoRequest extends FormRequest
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
            'banner_sec_two_id' => 'required|exists:banner_sec_two,id',
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10000', // Handle file uploads
            'link' => 'required|url'

        ];
    }
}
