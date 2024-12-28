<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\BankAccount;
use Illuminate\Foundation\Http\FormRequest;

class UserDocumentUpdate extends FormRequest
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
            'id_card_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'personal_picture_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'document_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
            'id_card_file' => 'عکس از کارت ملی',
            'personal_picture_file' => 'عکس پرسنلی',
            'document_file' => 'عکس از کدرک تحصیلی',
        ];
    }
}
