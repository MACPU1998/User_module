<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProjectUpdate extends FormRequest
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
            //

            'status' => 'required|int|in:1,2,3,4',
            'comment' => 'nullable|string|max:255'
//            "serial_number" => 'required|array|min:1|max:10',
//            'serial_number.*' => 'required|string|min:6|max:255',

        ];
    }
}
