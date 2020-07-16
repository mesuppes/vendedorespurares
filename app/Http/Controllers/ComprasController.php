<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function index()
    {
        
        $listaCompras=Compra::all();

        return view('listaPedidos', compact('listaCompras'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }

    public function createVendedor()
    {  
        #$nuevoVendedor=OptionList::create([
        #        'id_interno'=>request()

      #]);
    }


}
