<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubmitOrder extends FormRequest
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
                'description' => 'nullable|string|max:255',
                'final_items' => 'required|array',
                'final_items.*.product_id' => 'required|integer',
                'final_items.*.quantity' => 'required|integer|min:1|max:1000',
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
             'description' => 'توضیحات',
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
