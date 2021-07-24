<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric',
            'identification_number' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
