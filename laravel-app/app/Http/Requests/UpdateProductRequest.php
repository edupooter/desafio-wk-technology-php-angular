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
            ],
        ];
    }
}
