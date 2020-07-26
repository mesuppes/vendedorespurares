<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FacturaProforma;
use App\FacturaProformaItem;
use Auth;

class FacturasController extends Controller
{
    
    public function index()
    {
        $facturas=FacturaProforma::all();
        return view('listaFacturasProforma', compact('facturas'));
    }

    public function show($id){
    
        $usuario=Auth::user();
        $idPedido=FacturaProforma::find($id)->id_pedido;
        
        if($usuario->hasRole('Administracion') || #Si tiene el rol Admin
            PedidosController::canView($idPedido)){ #Si esta dentro de los que el usuario gestiono
     
                $factura=FacturaProforma::find($id);   
                return view('inspeccionarFacturaProforma', compact('factura')); 
        }else{
            return "prohibido!";
        }  
    }

    public function anular($id)
    {
        //
    }
}
