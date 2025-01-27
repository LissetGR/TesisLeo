<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReal extends FormRequest
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
            'cantidad'=> 'integer|required',
            'precio'=> 'decimal:2|required',
            'mes'=> ['string','required',
                    function ($attribute, $value, $fail) {
                        $allowedValues = ['Enero','Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'];
                        if (!in_array(strtolower($value), array_map('strtolower', $allowedValues))) {
                            $fail($attribute . ' Campo no valido');
                        }
                    }
                    ],
            'anno'=> 'string|required'
        ];
    }
}
