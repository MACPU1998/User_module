<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SalePartnerProfileImageUpdate extends FormRequest
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
            'personal_picture_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
            'personal_picture_file' => 'عکس پرسنلی',
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
