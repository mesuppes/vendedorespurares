<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests\CrearPedidoRequest;
use App\Http\Controllers\WorkflowController;

// USUARIO Y ROLES
use App\User;
use Auth;
use Spatie\Permission\Models\Role;

//MODELOS
use App\Pedido;
use App\Vendedor;
use App\Producto;
use App\PedidoProducto;
use App\ProductoView;
use App\WorkflowN;



#   TO DO
/*
        OK-Query: producto -> precio actualizado dentro de fecha_desde + Dcto producto/Vendedor
    -Validar stock
        OK-Decodificar WF
    -En el index enviar estado + Monto (siempre teniendo en cueta el ultimo)
        OK-Aprobar pedido + WF
        -Modificar Pedido + WF
        -Validación rol para omitir aprobación
*/

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
    public function create($idVendedor = 0)
    {

        #Si el usuario no tiene rol de vendedor


        if ($idVendedor) {
            #Lista de venededores

            $productos= PedidosController::tablaProductoDescuento($idVendedor);

            return view('agregarPedido')->with(compact('productos'));

        }elseif (Auth::user()->hasRole('Vendedor')) {
            #Vendedor que lo está cargando
            //$vendedores=$usuario->vendedor;
            $idUsuario=User::find(Auth::user()->id);

            $productos= PedidosController::tablaProductoDescuento($idUsuario);

            return view('agregarPedido')->with(compact('productos'));

        }else{
            return "ERROR - Su rol no permite realizar la operación";
        }}

public function createAdmin()
    {
        if (Auth::user()->hasRole('Administracion')) {
            #Lista de venededores
            $vendedores=Vendedor::get();

            return view('seleccionarVendedor')->with(compact('vendedores'));

        }elseif (Auth::user()->hasRole('Vendedor')) {
            #Vendedor que lo está cargando
            //$vendedores=$usuario->vendedor;

            $productos= PedidosController::tablaProductoDescuento($idUsuario);

            return view('agregarPedido')->with(compact('productos'));

        }else{
            return "ERROR - Su rol no permite realizar la operación";
        }}

        #Producto+Precio+Stock+Descuento para ese vendedor

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearPedidoRequest $request,$idPedidoPadre)
    {

        //VALIDAR STOCK

        //CREAR PEDIDO
        $NuevoPedido= Pedido::create([
            'id_pedido_padre'=>$idPedidoPadre,
            'id_vendedor'   =>$request['idVendedor'],
            'forma_entrega' =>$request['formaEntrega'],
            'datos_flete'   =>$request['datosFlete'],
            'condicion_pago'=>$request['condicionPago'],
            'id_usuario_reg'=>Auth::user()->id,
        ]);

        $idPedido = $NuevoPedido->id_pedido;

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
        }

        //CREAR WORKFLOW
        $respuesta=WorkflowController::agregarPedidoCreate($request['idVendedor'],$idPedido);

        return 1; //Mensaje de Exito + WF// -> show pedido cargado

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
        //Se debe envíar la lista de productos faltante
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,$idWfLast)
    {

        //0-Enviar el IDPedidoPadre
        $pedido=Pedido::find($id);
        if ($pedido->id_pedido_padre == null) {
            $idPedidoPadre= $pedido->id_pedido;
        }else{
            $idPedidoPadre= $pedido->id_pedido_padre;
        }

        //1-Ejecutar el create

        #$Respuesta=PedidosController::store($idPedidoPadre, CrearPedidoRequest $request);

        //2-Cerrar el flujo de aprobación que habia abierto
        $newStatus= 5;//Modiicado
        $respuestaWF=WorkflowController::actualizar($idWfLast,$newStatus);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Anular Pedido
    }

    public function approve($idWF)
    {
        //Aprobar Pedido
        #1-Actualizar WF
        $newStatus= 2;
        $respuestaWF=WorkflowController::actualizar($idWF,$newStatus);

        #2-Actualizar Stock
        #3-Generar factura Proforma
        #4-Generar deuda en el vendedor

    }

    public function validarStock($productosArray,$tipoMedidaArray,$cantidadArray)
    {
        //Validar que exista stock

    }


    static public function tablaProductoDescuento($idVendedor){

    #Retorna el stock y los descuentos para el vendedor selecionado

        $productosTabla=DB::table('v_productos_precio_stock AS p_v')
                            ->leftJoin('vendedores_dto_prod AS p_d',function($join) use ($idVendedor){
                                    $join->on('p_d.id_producto','=','p_v.id_producto');
                                    $join->where('p_d.id_vendedor','=', $idVendedor);
                                })
                            ->join('vendedores_dto_general AS v_d',function($join) use ($idVendedor){
                                    $join->where('v_d.id_vendedor','=', $idVendedor);
                                })
                            ->select('p_v.*','p_d.descuento AS descuento_producto','p_d.id_vendedor','v_d.descuento AS descuento_Vendedor')
                            ->get();

        return $productosTabla;
    }

    public function cargarProductos(Request $request)
    {
        $id_vendedor = $request->idVendedor;

        $productos= PedidosController::tablaProductoDescuento($id_vendedor);

        return response()->json(['success'=>$productos]);
    }



}
