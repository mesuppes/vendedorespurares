<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendedorCreateRequest extends FormRequest
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
            'nombre'        =>'required',
            'apellido'      =>'nullable',
            'telefono1'     =>'required',
            'telfono2'      =>'nullable',
            'email'         =>'required|email',//Formato de mail 
            'tipoDocumento' =>'required',
            'inscripcionAfip'=>'required',
            'cuit'          =>'required|unique:vendedores,cuit',//No exista para otro vendedor
            'codigoPostal'  =>'nullable',
            'provincia'     =>'required',
            'ciudad'        =>'required',
            'direccion'     =>'required',
        ];
    }
}
