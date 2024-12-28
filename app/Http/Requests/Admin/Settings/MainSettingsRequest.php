<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class MainSettingsRequest extends FormRequest
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
            "program_title"=>[
                "required"
            ],
            "phone"=>[
                "nullable"
            ],
            "email"=>[
                "nullable"
            ],
            "rules_content"=>[
                "nullable"
            ],
        ];
    }

    public function attributes()
    {
        return [
            "program_title" => __("general.program_title")
        ];
    }
}
