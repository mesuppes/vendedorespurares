<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendedorUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'        =>'required',
            'apellido'      =>'required',
            'telefono1'     =>'required',
            'telfono2'      =>'nullable',
            'email'         =>'required|email',//Formato de mail 
            'tipoDocumento' =>'required',
            'inscripcionAfip'=>'required',
            'cuit'          =>'required',//No exista para otro vendedor
            'codigoPostal'  =>'nullable',
            'provincia'     =>'required',
            'ciudad'        =>'required',
            'direccion'     =>'required',
        ];
    }
}
