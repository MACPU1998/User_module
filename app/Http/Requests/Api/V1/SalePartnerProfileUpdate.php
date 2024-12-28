<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SalePartnerProfileUpdate extends FormRequest
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
            // 'first_name' => 'required|string|persian_alpha|min:3|max:128',
            // 'last_name' => 'required|string|persian_alpha|min:3|max:128',
            // 'father_name' => 'nullable|string|persian_alpha|min:3|max:128',
            'address' => 'required|string',
            'phone' => 'nullable|numeric|ir_phone_with_code|unique:users,phone,'.auth()->user()->id.',id,deleted_at,NULL',
            // 'province_id' => 'required|numeric|exists:provinces,id',
            // 'city_id' => 'required|numeric|exists:cities,id',
            // 'birthdate' => 'required|date',
            'postal_code' => 'nullable|numeric|ir_postal_code',
            'bank_account_number' => ['nullable','string',new BankAccount()],
            'bank_sheba' => 'nullable|string|ir_sheba',
            'bank_card_number' => 'nullable|numeric|ir_bank_card_number',
            'personal_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            // 'first_name' => 'نام',
            // 'last_name' => 'نام خانوادگی',
            // 'father_name' => 'نام پدر',
            'address' => 'آدرس',
            // 'mobile' => 'موبایل',
            'phone' => 'تلفن ثابت',
            'national_code' => 'کد ملی',
            // 'province_id' => 'استان',
            // 'city_id' => 'شهرستان',
            // 'gender' => 'جنسیت',
            // 'birthdate' => 'تاریخ تولد',
            'postal_code' => 'کد پستی',
            'bank_account_number' => 'شماره حساب بانکی',
            'bank_sheba' => 'شماره شبا',
            'bank_card_number' => 'شماره کارت بانکی',
            // 'id_card_file' => 'عکس از کارت ملی',
            'personal_image_file' => 'عکس پرسنلی',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Customize the response format
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
