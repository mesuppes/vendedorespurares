<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArmarPedidoRequest extends FormRequest
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


    public function rules()
    {
        return [
            'idPedido'      =>'required',
            'idProducto'    =>'required',
            'cantidadUnidades'=>'required',
            'cantidadKg'    =>'required',            
        ];
    }
}
