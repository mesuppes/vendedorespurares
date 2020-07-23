<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FacturaProforma;
use App\FacturaProformaItem;

class FacturasController extends Controller
{
    
    public function index()
    {
        $facturas=FacturaProforma::all();
        return view('listaFacturasProforma', compact('facturas'));
    }

    public function show($id)
    {
     
        $factura=FacturaProforma::find($id);
        return view('inspeccionarFacturasProforma', compact('factura'));   
    }

    public function anular($id)
    {
        //
    }
}
