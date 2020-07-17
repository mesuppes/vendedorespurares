<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idProductoProduccion'  =>'nullable',
            'nombreComercial'       =>'required',//|unique:Producto,nombre_comercial',
            //'urlFoto'               =>'requiere',
            'descripcion'           =>'nullable',
            'pesoUnitario'          =>'required',
        ];
    }
}
