<?php

namespace App\Http\Requests\Admin\Permissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class PermissionUpdateRequest extends FormRequest
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
            "name" => [
                "required",
                Rule::unique('permissions',"name")->where('id',"<>", $this->input('permission')),
                "min:3",
                "max:100"
            ],
            "slug" => ["required","min:3","max:100"],
            "sort" => ["required"],
            "active" => ["required"],
        ];
    }
}
