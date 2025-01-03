<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GiftshopProductUpdate extends FormRequest
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
            //
            'title' => 'required|string|min:3|max:64',
            'description' => 'required|string|max:500',
            'cost_value' => 'required|numeric|min:1|max:100000',
            'stock' => 'required|numeric|min:0',
            'status' => 'required|int|in:0,1,2,3,4,5',
            'thumbnail' => 'file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
