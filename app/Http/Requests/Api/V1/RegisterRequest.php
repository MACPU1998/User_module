<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|int|in:0,1',
            'first_name' => 'required|string|persian_alpha|min:3|max:128',
            'last_name' => 'required|string|persian_alpha|min:3|max:128',
            'father_name' => 'nullable|string|persian_alpha|min:3|max:128',
            'address' => 'required|string',
            'mobile' => [
                'required',
                'numeric',
                'ir_mobile:zero',
                Rule::unique('users')->where(function ($query) { $query->whereNull('deleted_at');})
            ],
            'phone' => [
                'nullable',
                'numeric',
                'ir_phone_with_code',
                Rule::unique('users')->where(function ($query) { $query->whereNull('deleted_at');})
            ],
            'national_code' => [
                'nullable',
                'ir_national_code',
                Rule::unique('users')->where(function ($query) { $query->whereNull('deleted_at');})
                ],
            'province_id' => 'required|numeric|exists:provinces,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'gender' => 'required|int|in:0,1',
            'birthdate' => 'required|date',
            'postal_code' => 'nullable|numeric|ir_postal_code',
            'bank_account_number' => ['nullable','string',new BankAccount()],
            'bank_sheba' => 'nullable|string|ir_sheba',
            'bank_card_number' => 'nullable|numeric|ir_bank_card_number',
            'id_card_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'personal_picture_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'document_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'education' => 'required|int|in:0,1,2,3,4,5',
            'dress_size' => 'required|int|in:0,1,2,3,4',
            'referral' => 'nullable|string',
            'describe' => 'nullable|string',
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
            'type' => 'نوع',
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'father_name' => 'نام پدر',
            'address' => 'آدرس',
            'mobile' => 'موبایل',
            'phone' => 'تلفن ثابت',
            'national_code' => 'کد ملی',
            'province_id' => 'استان',
            'city_id' => 'شهرستان',
            'gender' => 'جنسیت',
            'birthdate' => 'تاریخ تولد',
            'postal_code' => 'کد پستی',
            'bank_account_number' => 'شماره حساب بانکی',
            'bank_sheba' => 'شماره شبا',
            'bank_card_number' => 'شماره کارت بانکی',
            'id_card_file' => 'عکس از کارت ملی',
            'personal_picture_file' => 'عکس پرسنلی',
            'document_file' => 'عکس از کدرک تحصیلی',
            'education' => 'تحصیلات',
            'dress_size' => 'سایز لباس کار',
            'referral' => 'کد معرف',
            'describe' => 'توضیحات',
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
