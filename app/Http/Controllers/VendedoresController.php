<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendedor;
use App\VendedorDescuentoGeneral;
use App\VendedorDescuentoProducto;
use App\Http\Requests\VendedorCreateRequest;
use App\Http\Requests\VendedorDescuentoCreateRequest;

class VendedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores=Vendedor::get();

        return view('listaVendedores', compact('vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // ---!!! CREAR VENDEDORES !!!--- //

    public function create()
    {
        return view('VendedorCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendedorCreateRequest $request)
    {
       
    //1-Crear Vendedor
        $nuevoVendedor=Vendeor::Create([
            'nombre'    =>$request['nombre'],
            'apellido'  =>$request['apellido'],
            'telfono1'  =>$request['telfono1'],
            'telefono2' =>$request['telefono2'],
            'email'     =>$request['email'],
            'cuit'      =>$request['cuit',]
            'provincia' =>$request['provincia'],
            'ciudad'    =>$request['ciudad'],
            'direccion' =>$request['direccion'],
            'id_usuario_reg'=> Auth::user()->id,
        ]);

    //2-Crear descuentos para vendedor
        return view('VendedorDescuentoCreate'->with($nuevoVendedor->id_vendedor));
       
    }

    // ---!!! CREAR DESCUENTOS !!!--- //

    public function createDescuentos($idVendedor){

        $vendedor=Vendedor::find($idVendedor);
        $productos=Producto::all();

        return view('VendedorDescuentoCreate'->with(compact('vendedor','productos')));

    }

    public function storeDescuento(VendedorDescuentoCreateRequest $request){

        //1-Guardar el descuento General
            VendedorDescuentoGeneral::create([
                'id_vendedor'   =>$request['idVendedor'],  
                'descuento'     =>$request['descuentoGeneral'],
                'id_usuario_reg'=>Auth::user()->id,
            ]);

        //2-Guardar el descuento por Producto
            $longitud=count($request['idProducto']);
            for ($i=0; $i <$longitud ; $i++) { 
                if ($request['descuentoProducto']>0) {
                    VendedorDescuentoProducto::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'id_producto'   =>$request['idProducto'],
                        'descuento'   =>$request['descuentoProducto'],
                        'id_usuario_reg'=>Auth::user()->id,
                    ]);
                }
            }
        //3-Crear Usuario Vendedor

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Mostrar el vendedor
        $vendedor=Vendedor::find($idVendedor);
        //Mostrar Descuentos
        $descuentoGeneral=$vendedor->descuentoGeneral;
        $descuentoProductos=$vendedor->->descuentoProducto;
        //Mostrar el usuario
        $usuario=$vendedor->usuario;

        return view('VendedorShow'->with(compact('vendedor','descuentoGeneral','descuentoProductos','usuario')));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //

    public function update(VendedorCreateRequest $request, Vendedor $vendedor)
    {
        $vendedor->update($request->validated());

        //return succesmsg + Update de view 

    }

    public function updateDescuento(VendedorCreateRequest $request, Vendedor $vendedor)
    {
        
        //1-Guardar el descuento General
            VendedorDescuentoGeneral::Update([
                'id_vendedor'   =>$request['idVendedor'],  
                'descuento'     =>$request['descuentoGeneral'],
                'id_usuario_reg'=>Auth::user()->id,
            ]);

        //2-Eliminar los registros viejos
            $vendedor->descuentoProductos()->delete(); //$vendedor=Vendedor::Find($request['idVendedor'])

        //3-Guardar el descuento por Producto
            $longitud=count($request['idProducto']);   
            for ($i=0; $i <$longitud ; $i++) { 
                if ($request['descuentoProducto']>0) {
                    VendedorDescuentoProducto::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'id_producto'   =>$request['idProducto'],
                        'descuento'   =>$request['descuentoProducto'],
                        'id_usuario_reg'=>Auth::user()->id,
                    ]);
                }
            }
        //return succesmsg + Update de view        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
