<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCreateRequest extends FormRequest
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
            "first_name"=>["required","max:100","min:3"],
            "last_name"=>["required","max:100","min:3"],
            "email"=>["required","max:100","email",
                Rule::unique('admins',"email")->where(function ($query) { $query->whereNull('deleted_at');})],
            "phone"=>["required","max:100",
                Rule::unique('admins',"phone")->where(function ($query) { $query->whereNull('deleted_at');})],
            "password"=>["required","string","max:32"],
            "role"=>["required"],
            "status"=>["required"],
        ];
    }
}
