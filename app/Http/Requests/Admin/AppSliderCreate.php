<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppSliderCreate extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'title' => 'nullable|string|min:3|max:255',
            'link' => 'nullable|string|max:255',
            'status' => 'required|int|in:0,1,2,3,4,5',
            'media' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
