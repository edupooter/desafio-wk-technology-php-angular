<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $current = Carbon::now();
        $oldEnough = $current->sub(18, 'years')->toDateString();

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'cpf' => [
                'required',
                'string',
                'max:14',
                'cpf',
                'unique:customers,cpf',
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:'.$oldEnough,
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                'unique:customers,email',
            ],
            'ad_cep' => [
                'required',
                'string',
                'formato_cep',
            ],
            'ad_street' => [
                'required',
                'string',
                'max:255',
            ],
            'ad_number' => [
                'required',
                'numeric',
                'min:0',
                'max:100000',
            ],
            'ad_comp' => [
                'required',
                'string',
                'max:255',
            ],
            'ad_city' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
