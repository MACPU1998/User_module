<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketRequest extends FormRequest
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
            "title"=>["required"],
            "ticket_category_id"=>["required"],
            "department_id"=>["required"],
            "message"=>["required"],
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

    public function attributes(): array
    {
        return [
            'department_id' => 'دپارتمان',
            'title' => 'عنوان',
            'ticket_category_id' => 'دسته بندی تیکت',
            'title' => 'عنوان',
            'title' => 'عنوان',

        ];
    }

}
