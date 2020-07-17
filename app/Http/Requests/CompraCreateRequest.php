<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return false;
    }

   
    public function rules()
    {
        return [
            'idProveedor'=>'required',
                #Exista en la BD
            'nroRemito'=>'required',
            'fechaCompra'=>'required',
                #formato fecha
            'comentarios'=>'nullable',
            'id_producto'=>'required',
            'unidades'=>'required',
            'peso_kg'=>'required',
        ];
    }
}
