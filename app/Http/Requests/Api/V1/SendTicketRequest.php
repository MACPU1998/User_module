<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;
use Illuminate\Foundation\Http\FormRequest;

class SendTicketRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:128',
            'department_id' => 'required|exists:departments,id',
            'message' => 'required|min:3|max:500',
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
            'department_id' => 'دپارتمان',
            'message' => 'متن پیام',
        ];
    }
}
