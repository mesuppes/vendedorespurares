<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearPedidoRequest extends FormRequest
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
            #'idVendedor'    =>'required',
                #Exista en la BD 
            'requiereAprob' =>'nullable',
            'idPedidoPadre' =>'nullable',
                #Exista en la BD
            //'requiereAprob' =>'required',
                #Puede que no sea necesario ponerla en el request
            'formaEntrega'  =>'required',
            'datosFlete'    =>'required',
            'condicionPago' =>'required',
            'idProducto'    =>'required',
                #Exista en la BD (para c/u)
            'tipoMedida'    =>'required',
                # kg/unidades
            'cantidad'      =>'required',
            'requiereAprobacion'=>'nullable',
                # mayor a 0
                # stock Suficiente
        ];
    }
}
