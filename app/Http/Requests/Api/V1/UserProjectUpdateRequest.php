<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;
use Illuminate\Foundation\Http\FormRequest;

class UserProjectUpdateRequest extends FormRequest
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
            //'title' => 'required|string|persian_alpha|min:3|max:128',
            'client_first_name' => 'required|string|persian_alpha|min:3|max:128',
            'client_last_name' => 'required|string|persian_alpha|min:3|max:128',
            'client_address' => 'required|string|min:3|max:255',
            'client_phone' => 'required|numeric|ir_mobile:zero',
            'client_national_code' => 'nullable|ir_national_code',
            'client_province_id' => 'required|numeric|exists:provinces,id',
            'client_city_id' => 'required|numeric|exists:cities,id',
            "serial_number" => 'required|array|min:1|max:10',
            'serial_number.*' => 'required|string|min:6|max:255',
            'client_zipcode' => 'nullable|numeric|ir_postal_code',
            'picture1' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'picture2' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'picture3' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'picture4' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'picture5' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'sale_partner_name' => 'nullable|string|min:3|max:64',
            'description' => 'nullable|string',
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
            'title' => 'عنوان',
            'serial_number' => 'سریال محصول',
            'client_first_name' => 'نام مشتری',
            'client_last_name' => 'نام خانوادگی مشتری',
            'client_mobile' => 'موبایل مشتری',
            'client_national_code' => 'کد ملی مشتری',
            'client_province_id' => 'استان پروژه',
            'client_address' => 'آدرس مشتری',
            'client_city_id' => 'شهرستان پروژه',
            'client_zipcode' => 'کد پستی مشتری',
            'picture1' => 'تصویر اول',
            'picture2' => 'تصویر دوم',
            'picture3' => 'تصویر سوم',
            'picture4' => 'تصویر چهارم',
            'picture5' => 'تصویر پنجم',
            'sale_partner_name' => 'نام عامل فروش',
            'description' => 'توضیحات',
        ];
    }
}
