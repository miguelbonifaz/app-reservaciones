<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
{
    public function messages()
    {
        return [
          'servicesId.required' => 'Debe escojer al menos un servicio',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|numeric',
            'servicesId' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
