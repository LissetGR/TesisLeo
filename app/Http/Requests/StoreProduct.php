<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'nombre'=> 'string|required|min:3',
            'u_medida'=> 'string|required',
            'photo'=>'image'
        ];
    }

    public function attributes()
    {
        return [
          'nombre'=> 'nombre del producto',
           'u_medida'=> 'unidad de medida del producto',

        ];
    }
}
