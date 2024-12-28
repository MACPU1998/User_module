<?php

namespace App\Http\Requests\Admin\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class TicketCategoryRequest extends FormRequest
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
            "name"=>[
                "required","min:3","max:150"
            ],
            "slug"=>[
                "required","min:3","max:150"
            ],
            "sort"=>["required"],
            "active"=>["required"]
        ];
    }
}
