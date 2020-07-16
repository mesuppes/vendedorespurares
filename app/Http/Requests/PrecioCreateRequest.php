<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrecioCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idProducto'=>'require',
            'precioKg'=>'require',
            'precioUnidad'=>'require',
            'fechaDesde'=>'require',
                //No tiene que existir ninguna fecha posterior ni igual
                //tiene que ser mayor a hoy
        ];
    }
}
