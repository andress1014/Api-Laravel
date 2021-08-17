<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|min:4|max:150',
            'descripcion' => 'required|min:4',
            'stock' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'nombre.*' => 'Nombre debe tener maximo 4 caracteres',
            'descripcion.*' => 'Descripción debe tener minimo 4 caracteres',
            'stock.required' => 'La cantidad debe ser mayor a 0'
        ];
    }
}
