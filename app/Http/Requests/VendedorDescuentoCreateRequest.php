<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendedorDescuentoCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idVendedor'        =>'required',
            'idDescuentoGeneral'=>'required',
            'idProducto'        =>'nullable',
            'descuentoProducto' =>'nullable | between:0,100',
        ];
    }
}


/*

ROLES
1)ADMINSTRADOR GENERAL
    -Anular Factura
    -Gestionar Precios
    -Gestionar Clientes
        Detalle
        Usuario
        Creditos(*)
        Descuentos(*)

2)ADMINISTRACIÓN
    -Cargar Compras (y anular)
    -Cargar Pedido
        solicitar aprob Cliente
        dejar en cola para armar
    -Armar Pedidos
    -Gestionar Clientes
        Detalle
        Usuario

3)GESTOR DE CLIENTES
    -Puede cargar pedidos a cualquier cliente
        Aprueba 2 (administracion pedidos)
    
4)CLIENTE
    -Puede cargar sus pedidos
        Aprueba 2 (administracion pedidos)



*/