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
            'idProveedor'=>'nullable',#'required',
                #Exista en la BD
            'nroRemito'=>'nullable',#'required',
            'fechaCompra'=>'nullable',#'required',
                #formato fecha
            'comentarios'=>'nullable',
            'id_producto'=>'nullable',#'required',
            'unidades'=>'nullable',#'required',
            'peso_kg'=>'nullable',#'required',
        ];
    }
}
