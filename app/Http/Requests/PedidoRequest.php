<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            "idCuenta" => [
                "required",
                'exists:cuentas,idCuenta',
            ],
            "product" => ["required", "max:200"],
            "amount" => 'required|numeric',
            "value" => 'required|numeric',
            'total' => [
                'required',
                'numeric',
                $this->calcularTotalRule(),
            ],
        ];
    }

    protected function calcularTotalRule()
    {
        return function ($attribute, $value, $fail) {
            $amount = $this->input('amount');
            $value = $this->input('value');
            $total = $this->input('total');

            $calculatedTotal = $value*$amount;

            if ($calculatedTotal != $total) {
                $fail('El total no es válido.');
            }
        };
    }



    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'response' => 'error_form',
            'data' => $validator->errors()

        ], 400));
    }
}
