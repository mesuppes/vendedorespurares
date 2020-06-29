<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\CrearPedidoRequest;
use Illuminate\Http\Request;
//MODELOS
use App\Pedido;
use App\Vendedor;
use App\Producto;
use App\PedidoProducto;
use App\ProductoView;
use App\WorkflowN;


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
                $producto=ProductoView::find($request['idProducto'][$i]);
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
                    'id_producto'=>$request['idProducto'][$i],
                    'tipo_medida'=>$request['tipoMedida'][$i],
                    'cantidad'=>$request['cantidad'][$i],
                    'precio_unitario'=>$precio,
                    'descuento'=>$descuento,
                    'precio_final'=>$precio*$request['cantidad'][$i]
                ]);
            }
        //CREAR WORKFLOW

        //$respuesta=Workflow::agregarPedidoCreate($request['idVendedor'],$idPedido);



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

        //Buscar El Pedido Hijo mas Reciente
        $pedidoHijo=Pedido::where('id_pedido_padre','=',$id)->latest()->first();

        //Si no tiene pedido Hijo Muestra el Pedido Padre
        if ($pedidoHijo==null) {
            $pedidoDescUltimo=Pedido::find($id);
            $pedidoProdUltimo= $pedidoDescUltimo->productos;
        }else{
            $pedidoDecUltimo=$pedidoHijo;
            $pedidoDescAnterior=Pedido::where('id_pedido_padre','=',$id)->latest()->skip(1)->first();
            $pedidoProdUltimo=$pedidoDescUltimo->productos;
            $pedidoProdAnterior=$pedidoProdAnterior->productos;
        }

        //WORKFLOW
        $wf=WorkflowN::where([
                                ['task_type','=','1'], // 1->Corresponde a la tabla Pedido
                                ['id_task','=',$pedidoDescUltimo->id_pedido]
                            ])
                    ->get();

        return view('inspeccionarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','pedidoDescAnterior','pedidoProdAnterior','wf'));
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

    }

    public function prueba(){
        /*
        $ListaPrecios=DB::table('productos_descripcion as p_d')
            ->join('precios as p_p','p_p.id_producto','=','p_d.id_producto')
            ->select('p_d.id_producto', 'p_p.precio_kg','p_p.precio_unidad','p_p.fecha_desde')

            ->get();
        */

        $ListaPrecios= Producto::where(fuction ($query){
            $query->select('id_producto')
                    ->from('precios')
                    ->whereColumn('id_producto','productos_descripcion.id_producto')
                    ->orderByDesc('fecha_desde')
                    ->limit(1)
        },'id_producto')->get();

        return $ListaPrecios;
    }



}
