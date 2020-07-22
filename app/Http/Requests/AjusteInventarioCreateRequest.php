<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AjusteInventarioCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'motivo'=>'required',
            'idProducto'=>'required',
            'loteProduccion'=>'required',
            'loteCompra'=>'required',
            'unidades'=>'required',
            'pesoKg'=>'required',
        ];
    }
}
