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
            'idVendedor'    =>'required',
<<<<<<< HEAD
                #Exista en la BD 
            'requiereAprob' =>'nullable',
=======
                #Exista en la BD
            //'requiereAprob' =>'required',
                #Puede que no sea necesario ponerla en el request
>>>>>>> 004cd8ff8000af9feb0cfc46618da6fb3619cbca
            'formaEntrega'  =>'required',
            'datosFlete'    =>'required',
            'condicionPago' =>'required',
            'idProducto'    =>'required',
                #Exista en la BD (para c/u)
            'tipoMedida'    =>'required',
                # kg/unidades
            'cantidad'      =>'required',
                # mayor a 0
                # stock Suficiente
        ];
    }
}
