<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric',
            'name_of_child' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
