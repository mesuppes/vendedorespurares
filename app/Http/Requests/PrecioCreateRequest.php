<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrecioCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idProducto'    =>'required',
            'precioKg'      =>'required',
            'precioUnidad'  =>'required',
            //'fechaDesde'    =>'required',
                //No tiene que existir ninguna fecha posterior ni igual
                //tiene que ser mayor a hoy
        ];
    }
}
