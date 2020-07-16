<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendedor;
use App\Producto;
use App\VendedorCredito;
use App\VendedorDescuentoGeneral;
use App\VendedorDescuentoProducto;
use App\Http\Requests\VendedorCreateRequest;
use App\Http\Requests\VendedorDescuentoCreateRequest;
use Auth;

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
            'cuit'      =>$request['cuit'],
            'provincia' =>$request['provincia'],
            'ciudad'    =>$request['ciudad'],
            'direccion' =>$request['direccion'],
            'id_usuario_reg'=> Auth::user()->id,
        ]);

    //2-Crear descuentos para vendedor
        return view('VendedorDescuentoCreate'->with($nuevoVendedor->id_vendedor));

    }

    // ---!!! CREDITOS !!!--- //

    public function createCredito($idVendedor){


        $vendedor=Vendedor::find($idVendedor);

        return view('asignarCredito')->with(compact('vendedor'));
    }

    public function storeCredito(){

        VendedorCredito::create([
            'id_vendedor'=>request('idVendedor'),
            'monto'=>request('monto'),
            'id_usuario_reg'=>Auth::user()->id,
            ]);
        //return redirect()
    }


    // ---!!!DESCUENTOS !!!--- //

    public function createDescuentos($idVendedor){

        $vendedor=Vendedor::find($idVendedor);
        $productos=Producto::all();

        return view('asignarDescuentos')->with(compact('vendedor','productos'));
    }


    public function storeDescuento(VendedorDescuentoCreateRequest $request){

        //1-DESCUETO GENETAL
        
        #Buscar descuento
        $DescuentoGeneral=VendedorDescuentoGeneral::where('id_vendedor','=',$request['idVendedor']);
         
         if (count($DescuentoGeneral->get()) == null) {
        //NO EXISTE->Guardar el descuento General
            $dg=VendedorDescuentoGeneral::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'descuento'     =>$request['descuentoGeneral'],
                        'id_usuario_reg'=>Auth::user()->id,
            ]);
         }else{
        //EXISTE->actualizar el descuento General
            $dg=$DescuentoGeneral->update([
                        'id_vendedor'   =>$request['idVendedor'],
                        'descuento'     =>$request['descuentoGeneral'],
                        'id_usuario_act'=>Auth::user()->id,
            ]);
        }

        //2-DESCUENTO POR PRODUCTO
            #Eliminar descuentos por productos viejos
            VendedorDescuentoProducto::where('id_vendedor','=',1)->delete();
            #Guardar el descuento por Producto            
            $longitud=count($request['idProducto']);
            for ($i=0; $i <$longitud ; $i++) {
                if ($request['descuentoProducto'][$i]>0) { //Guardar solo si es mayor a cero
                    VendedorDescuentoProducto::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'id_producto'   =>$request['idProducto'][$i],
                        'descuento'     =>$request['descuentoProducto'][$i],
                        'id_usuario_reg'=>Auth::user()->id,
                    ]);
                }
            }
        return "exito!";

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
        //Mostrar Crédito
        $credito=$vendedor->credito->last();
        //Mostrar Descuentos
        $descuentoGeneral=$vendedor->descuentoGeneral;
        $descuentoProductos=$vendedor->descuentoProducto;
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
