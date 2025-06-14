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
            'u_medida'=> ['required', 'string', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
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

    public function messages(): array
    {
        return [
            'nombre.required' => 'El :attribute es obligatorio.',
            'nombre.string' => 'El :attribute debe ser una cadena de texto.',
            'nombre.min' => 'El :attribute debe tener al menos :min caracteres.',

            'u_medida.required' => 'La :attribute es obligatoria.',
            'u_medida.string' => 'La :attribute debe ser una cadena de texto.',
            'u_medida.regex' => 'La :attribute solo puede contener letras y espacios. No se permiten números ni símbolos.',

            'photo.image' => 'La foto debe ser un archivo de imagen válido.',
        ];
    }
}
