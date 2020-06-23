<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\CrearPedidoRequest;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Pedido;
use App\Vendedor;
use App\Producto;
use App\PedidoProducto;
use App\ProductoView;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaPedidos=Pedido::get();//llamar al Modelo

        return view('listaPedidos', compact('listaPedidos')); //dentro de Compact metemos la variable que esta en el modelo $listaPedidos
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $vendedores=Vendedor::get();
 
        $productos= ProductoView::get();
        

        return view('agregarPedido')->with(compact('productos','vendedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearPedidoRequest $request)
    {


        //CREAR PEDIDO
        Pedido::create([
            'id_pedido_padre'=> null,
            'id_vendedor'   =>$request['idVendedor'],
            'forma_entrega' =>$request['formaEntrega'],
            'datos_flete'   =>$request['datosFlete'],
            'condicion_pago'=>$request['condicionPago'],
            'id_usuario_reg'=>'1'
        ]);
        
        $idPedido = Pedido::latest('id_pedido')->first()->id_pedido;

        //AGREGAR PRODUCTOS AL PEDIDO

        //Cantidad producto
        $longitud=count($request['idProducto']);

        for ($i=0; $i <$longitud ; $i++) { 

            if ($request['cantidad'][$i]>0) {

                //Producto
                $producto=ProductoView::find($request['idProducto']);
                $descuento=0.25;

                //Determianr Precio (unitario/KG)
                if ($request['tipoMedida'][$i]=='kg') {
                    $precio=$producto['precio_kg'];
                }else{
                    $precio=$producto['precio_unidad'];
                }

                //Cargar en la DB
                PedidoProducto::create([
                    'id_pedido'=>$idPedido,
                    'id_producto'=>$idProducto,
                    'tipo_medida'=>$request['tipoMedida'][$i],
                    'cantidad'=>$request['cantidad'][$i],
                    'precio_unitario'=>$precio,
                    'descuento'=>$descuento,
                    'precio_final'=>$precio*$request['cantidad'][$i]
                ]);    
            }
        //CREAR WORKFLOW
        
        $respuesta=Workflow::agregarPedido($request['idVendedor'],$idPedido);

        

        }

        //return ->carten succesfull->vista de la orden creada 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
