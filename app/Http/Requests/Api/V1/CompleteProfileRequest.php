<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Http\Requests\Auth\GetRegisterFieldAndValueTrait;

class CompleteProfileRequest extends FormRequest
{

    use GetRegisterFieldAndValueTrait;

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
            'user_category_id' => 'required|exists:user_categories,id',
            'first_name' => 'required|string|persian_alpha|min:3|max:128',
            'address' => 'required|string',
            'mobile' => 'required|numeric|ir_mobile:zero|unique:users,cell_phone',
            'national_code' => 'required|ir_national_code|unique:users,national_code',
            'province_id' => 'required|numeric|exists:provinces,id',
            'city_id' => 'required|numeric|exists:cities,id',
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
            'user_category_id' => 'دسته بندی',
            'name' => 'نام',
            'address' => 'آدرس',
            'company_id' => 'شرکت',
            'tariff_id' => 'تعرفه',
            'phone' => 'تلفن ثابت',
            'cell_phone' => 'تلفن همراه',
            'password' => 'رمز عبور',
            'username' => 'نام کاربری',
            'w_cal' => 'ساعت کاری',
            'national_code' => 'کد ملی',
            'working_calendar' => 'ساعت کاری',
            'working_calendar.*.type' => 'روز هفته',
            'working_calendar.*.morning_start_time' => 'ساعت شروع کار صبح',
            'working_calendar.*.morning_end_time' => 'ساعت پایان کار صبح',
            'working_calendar.*.evening_start_time' => 'ساعت شروع کار عصر',
            'working_calendar.*.evening_end_time' => 'ساعت پایان کار عصر',
        ];
    }
}
