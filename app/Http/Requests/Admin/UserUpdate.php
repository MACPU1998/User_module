<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdate extends FormRequest
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
            'first_name' => 'required|string|persian_alpha|min:3|max:128',
            'last_name' => 'required|string|persian_alpha|min:3|max:128',
            'father_name' => 'nullable|string|persian_alpha|min:3|max:128',
            'address' => 'required|string',
            'mobile' => [
                'required',"ir_mobile:zero",
                Rule::unique('users','mobile')->ignore($this->user)->where(function ($query) { $query->whereNull('deleted_at');}),
            ],
            //'required|numeric|ir_mobile:zero|unique:users,mobile',
            'phone' =>[
                'nullable',"ir_phone_with_code",
                Rule::unique('users','phone')->ignore($this->user)->where(function ($query) { $query->whereNull('deleted_at');}),
            ],
            //'required|numeric|ir_phone_with_code|unique:users,phone',
            'national_code' => [
                'required',"ir_national_code",
                Rule::unique('users','national_code')->ignore($this->user)->where(function ($query) { $query->whereNull('deleted_at');}),
            ],
            //'required|ir_national_code|unique:users,national_code',
            //'province_id' => 'required|numeric|exists:provinces,id',
            //'city_id' => 'required|numeric|exists:cities,id',
            'gender' => 'required|int|in:0,1',
            'birthdate' => 'required|string',
            'postal_code' => 'nullable|numeric|ir_postal_code',
            'bank_account_number' => 'nullable|string|max:32',
            'bank_sheba' => 'nullable|string|ir_sheba',
            'bank_card_number' => 'nullable|numeric|ir_bank_card_number',
            'id_card_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'personal_picture_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'document_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'comment' => 'nullable|string'
            //'education' => 'required|int|in:0,1,2,3,4,5',
            //'dress_size' => 'required|int|in:0,1,2,3,4',
        ];
    }
}
