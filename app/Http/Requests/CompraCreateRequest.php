<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'idProveedor'=>'required',
            'nroRemito'=>'required',
            'fechaCompra'=>'required',
                #formato fecha
            'loteCompra'=>'required',
            'comentarios'=>'nullable',
            'idProducto'=>'required',
            'unidades'=>'required',
            'peso_kg'=>'required',
        ];
    }
}
