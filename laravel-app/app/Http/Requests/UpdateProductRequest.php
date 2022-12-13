<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                'min:0',
                'max:10000000',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute field can not be blank value',
            'amount.required' => 'The :attribute field can not be blank value',
            'amount.digits_between' => 'The :attribute field must be up to 10,000,000',
        ];
    }
}
