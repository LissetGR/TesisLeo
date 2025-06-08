<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
class StorePlan extends FormRequest
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
            'cantidad' => 'required|array|min:1',
            'precio' => 'required|array|min:0',
            'mes' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $allowedValues = [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                        'Junio', 'Julio', 'Agosto', 'Septiembre',
                        'Octubre', 'Noviembre', 'Diciembre'
                    ];
                    if (!in_array(ucfirst(strtolower($value)), $allowedValues)) {
                        $fail($attribute . ' no es válido.');
                    }
                },
            ],
            'anno' => 'required|integer|min:1900|max:' . date('Y'),
        ];
    }
}
