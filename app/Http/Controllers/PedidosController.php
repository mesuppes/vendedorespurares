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
use App\OptionList;
use App\FacturaProforma;
use App\FacturaProformaItem;
#use App\Role;



class PedidosController extends Controller
{

	public function index()
	{

	$idPedidos=DB::table('pedidos_reg')
				->selectRaw('MAX(id_pedido) as id')
				->groupBy('id_pedido_padre')
				->pluck('id')
				->toArray();

	$listaPedidos=Pedido::whereIn('id_pedido',$idPedidos)->get();

		return view('listaPedidos', compact('listaPedidos'));

	}

	//Se ejecuta el createRouter para determinar si muestra:
		//seleccioón de vendedor ->(para no Vendedores) 
		//La creación de pedido  ->(Vendedores)
	public function createRouter(){

		if (Auth::user()->hasRole('Administracion')) {
			$vendedores=Vendedor::all();
			return view('seleccionarVendedor')->with(compact('vendedores'));
		}elseif (Auth::user()->hasRole('Vendedor')) {
			PedidosController::create();
		}else{
			return "ERROR - Su rol no permite realizar la operación";
		}
	} 

	static public function create()
	{
		if (Auth::user()->hasRole('Administracion')) {
			$vendedor=Vendedor::find(request('idVendedor'));
			$productos= PedidosController::tablaProductoDescuento(request('idVendedor'));
			return view('agregarPedido')->with(compact('productos','vendedor'));
		}elseif (Auth::user()->hasRole('Vendedor')) {
			$vendedor=User::find(Auth::user()->id)->vendedor;
			$productos= PedidosController::tablaProductoDescuento($vendedor->id_vendedor);
			return view('agregarPedido')->with(compact('productos','vendedor'));
		}else{
			return "ERROR - Su rol no permite realizar la operación";
		}}

	//Almacenar el Pedido

	public function store(CrearPedidoRequest $request)
	{

		#return $request;    
		//VALIDAR STOCK
		//VALIDAR CRÉDITO

	//CREAR PEDIDO
		$nuevoPedido= Pedido::create([
			'id_pedido_padre'=>$request['idPedidoPadre'],
			'id_vendedor'   =>$request['idVendedor'],
			'forma_entrega' =>$request['formaEntrega'],
			'datos_flete'   =>$request['datosFlete'],
			'condicion_pago'=>$request['condicionPago'],
			'id_usuario_reg'=>Auth::user()->id,
		]);
		$idPedido = $nuevoPedido->id_pedido;
	   
	//AGREGAR PRODUCTOS AL PEDIDO
		//Cantidad producto
		$longitud=count($request['idProducto']);
		$tablaProducto= PedidosController::tablaProductoDescuento($request['idVendedor']);

		for ($i=0; $i <$longitud ; $i++) {
			if ($request['cantidad'][$i]>0) {
				$producto=$tablaProducto->where('id_producto','=',$request['idProducto'][$i])->first();
				//Determianr Precio (unitario/KG)
				if ($request['tipoMedida'][$i]=='kg') {
					$precio=$producto->precio_kg;
				}else{
					$precio=$producto->precio_unidad;
				}
				//Cargar en la DB
				PedidoProducto::create([
					'id_pedido'		=>$idPedido,
					'id_producto'	=>$request['idProducto'][$i],
					'tipo_medida'	=>$request['tipoMedida'][$i],
					'cantidad'		=>$request['cantidad'][$i],
					'precio_unitario'=>$precio,
					'descuento'		=>$producto->dcto_usar,
					'precio_final'	=>$precio*$request['cantidad'][$i]*(1- $producto->dcto_usar),
				]);
			}
		}
	
		if ($request['requiereAprobacion']==null) {
			$requiereAprobacion=0;
		}else{
			$requiereAprobacion=1;
		}        
	//CREAR WORKFLOW
		$respuesta=WorkflowController::agregarPedidoCreate($request['idVendedor'],$idPedido,$requiereAprobacion);

	#MENSAJE DE RESPUESTA
		#si el pedido queda pendiente de aprobación
		if ($respuesta->status==1) {
			if ($respuesta->to_user == null) {
				$to=$respuesta->toroleN->name;
			}else{
				$to=$respuesta->toUserN->name;
			}
		$msg="Su pedio se ha cargado correctamente. Se encuentra pendiente de aprobación por <b>"
		.$to."</b>";
		}elseif ($respuesta->status==4) {
			$msg="El pedido se ha cargado correctamente";
		}
		#mensaje de si el pedido se autoaprueba
		//....

	//RETURN
		return redirect('/listaPedidos/'.$respuesta->id_task)->with('pedidoAgregado',$msg);

	}

	public function show($id){

		//Buscar El Pedido Hijo mas Reciente
		$pedidoHijo=Pedido::where('id_pedido_padre','=',$id)->latest()->first();

		//Si no tiene pedido Hijo Muestra el Pedido Padre
		if ($pedidoHijo==null) {
			$pedidoDescUltimo=Pedido::find($id);
			$pedidoProdUltimo= $pedidoDescUltimo->productos;
			$pedidoDescAnterior=null;
			$pedidoProdAnterior=null;

		 }else{
			$pedidoDescUltimo=$pedidoHijo;
			$pedidoDescAnterior=Pedido::where('id_pedido_padre','=',$id)->latest()->skip(1)->first();
			if ($pedidoDescAnterior==null) {
				$pedidoDescAnterior=Pedido::find($id);
			}

			$pedidoProdUltimo=$pedidoDescUltimo->productos;
			$pedidoProdAnterior=$pedidoDescAnterior->productos;

		}
		//WORKFLOW
		$wf=WorkflowN::where([
								['task_type','=','1'], // 1->Corresponde a la tabla Pedido
								['id_task','=',$pedidoDescUltimo->id_pedido]
							])
					->first();

	$msjStatus=PedidosController::statusMensaje($wf->id_workflow);

	return view('inspeccionarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','pedidoDescAnterior','pedidoProdAnterior','wf','msjStatus'));

	}

	#MUESTRA EN FORMATO DE MENSAJE EL PEDIDO
	static public function statusMensaje($idWF){

		$wf=WorkflowN::find($idWF);
		
		if ($wf->user_done==null) {
		#SI NO ESTA HECHA 
			if ($wf->to_user != null) { #
				$to=$wf->toUserN->name;
			}else{
				$to=$wf->toRoleN->name;
			}
			$msg=$wf->taskTypeN->nombre." ".$wf->statusN->nombre." por ".$to;
		#SI YA ESTA HECHA
		}else{
			$msg=$wf->taskTypeN->nombre." ".
			$wf->statusN->nombre.
			" por ".$wf->userDoneN->name.
			" el ".$wf->date_done->formatLocalized('%d/%m/%Y a las %H:%M');
			
		}
		return $msg;
	}


	static public function armarPedidoCreate($idPedido){

		$pedidoDesc=Pedido::find($idPedido);

		$productosTabla=PedidosController::tablaDatosProductosOP($idPedido);
		
		return view('armarPedido')->with(compact('productosTabla','pedidoDesc'));

	}

	public function armarPedidoStore(ArmarPedidoRequest $request){

	//VALIDAR STOCK
	$productosTabla=PedidosController::tablaDatosProductosOP($idPedido);

	//GENERAR FACTURA PROFORMA
		
		$nuevaFactura= FacturaProforma::create([
			'id_cliente'	=>$request['idCliente'],
			'id_pedido'		=>$request['idPedido'],
			'tipo'			=>'1',
			'id_usuario_reg'=>Auth::user()->id,
			]);

		$idFactura=$nuevaFactura->id;

	//GENERAR ITEMS FACTURA PROFORMA
		#Buscar tabla de precios y descuento

		$longitud=count($request['idProducto']);
		for ($i=0; $i < $longitud; $i++) { 
			$producto=$productosTabla->where('id_producto','=',$request['idProducto'][$i])->first();
			#DETERMINAR QUE LA CANTIDAD SEA MAYOR A CERO
			if ($request['cantidadUnidades'][$i]>0 || $request['cantidadKg'][$i]>0) {
				
				#DETERMINAR DE QUE LISTA DE PRECIO SE REFIERE
				if ($listaPrecio=1) {
						#Determinar que precio utilizar (kg/unidad)
						if ($request['tipoUnidad'][$i]=='kg') {
							$precio=$producto->precio_kg;
						}else{
							$precio=$producto->precio_unidad;
						}
					$descuento=$producto->dcto_usar;
				}else{
					$precio=$producto->precio_unitario_pedido;
					$descuento=$producto->descuento_pedido;
				}
				#Determinar que cantidad utilizar
				if ($request['tipoUnidad'][$i]=='kg') {
					$cantidad=$request['cantidadKg'];
				}else{
					$cantidad=$request['tipoUnidad'];
				}

				#INSERT DB ITEM DE FACTURA PROFORMA 
				$nuevoItem=FacturaProformaItem::create([
					'id_factura_proforma'=>$idFactura,
					'id_producto'		=>$request['idProducto'],
					'cantidad_unidades'	=>$request['cantidadUnidades'],
					'cantidad_kg'		=>$request['cantidadKg'],
					'tipo_unidad'		=>$request['tipoUnidad'],
					'precio_unitario'	=>$precio,
					'descuento'			=>($precio*$cantidad)*$descuento,
					'precio_total'		=>($precio*$cantidad)*(1-$descuento),
				]);
				#INSERTAR MOVIMIENTO DE PRODUCTOS




			}
		}
		return "factura creada".$idFactura
		//return redirect('/listaFacturas/'.$idFactura)->with('facturaCreada');		
	}

/*
	public function edit($id)
	{
		//Se debe envíar la lista de productos faltante
		//Buscar El Pedido Hijo mas Reciente
		$pedidoHijo=Pedido::where('id_pedido_padre','=',$id)->latest()->first();

		//Si no tiene pedido Hijo Muestra el Pedido Padre
		if ($pedidoHijo==null) {
			$pedidoDescUltimo=Pedido::find($id);
			$pedidoProdUltimo= $pedidoDescUltimo->productos;
			$pedidoDescAnterior=null;
			$pedidoProdAnterior=null;
		//return view('inspeccionarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','wf'));
		}else{
			$pedidoDescUltimo=$pedidoHijo;
			$pedidoDescAnterior=Pedido::where('id_pedido_padre','=',$id)->latest()->skip(1)->first();
			if ($pedidoDescAnterior==null) {
				$pedidoDescAnterior=Pedido::find($id);
			}

			$pedidoProdUltimo=$pedidoDescUltimo->productos;
			$pedidoProdAnterior=$pedidoDescAnterior->productos;

		//return view('inspeccionarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','pedidoDescAnterior','pedidoProdAnterior','wf'));
	}
		 if (Auth::user()->hasRole('Administracion')) {
			#Lista de venededores
			$idVendedor=$pedidoDescUltimo->id_vendedor;

			 $productos= PedidosController::tablaProductoDescuento($idVendedor);
		}elseif (Auth::user()->hasRole('Vendedor')) {
			#Vendedor que lo está cargando
			//$vendedores=$usuario->vendedor;
			$idUsuario=Auth::user()->id;

			//$vendedor=Vendedor::find($idUsuario)->nombre;
			$vendedor=Auth::user()->name;

			$productos= PedidosController::tablaProductoDescuento($idUsuario);

	}

	return view('editarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','productos'));

	}

*/
	public function validarStock($productosArray,$tipoMedidaArray,$cantidadArray){

	}


	static public function tablaProductoDescuento($idVendedor){

	#Retorna el stock y los descuentos para el vendedor selecionado

		$productosTabla=DB::table('v_productos_precios AS p_v')
							->join('productos_descripcion AS p_desc','p_desc.id_producto','=','p_v.id_producto')
							->leftJoin('v_productos_stock AS p_s','p_s.id_producto','=','p_v.id_producto')
							->leftJoin('vendedores_dto_prod AS p_d',function($join) use ($idVendedor){
									$join->on('p_d.id_producto','=','p_v.id_producto');
									$join->where('p_d.id_vendedor','=', $idVendedor);
								})
							->join('vendedores_dto_general AS v_d',function($join) use ($idVendedor){
									$join->where('v_d.id_vendedor','=', $idVendedor);
								})
							->select('p_desc.nombre_comercial','p_desc.url_foto','p_v.*','p_d.descuento AS descuento_producto','p_d.id_vendedor','v_d.descuento AS descuento_Vendedor','p_s.stock_unidades','p_s.stock_kg',
								\DB::raw('(CASE 
											WHEN p_d.descuento>v_d.descuento
											THEN p_d.descuento
											ELSE v_d.descuento
											END) AS dcto_usar'))#usa el descuento mas alto
							->get();

		return $productosTabla;
	}



	static public function tablaDatosProductosOP($idPedido){

		$idVendedor=Pedido::find($idPedido)->id_vendedor;

		$productosTabla=DB::table('v_productos_precios AS p_v')
							->join('productos_descripcion AS p_desc','p_desc.id_producto','=','p_v.id_producto')
							->leftJoin('pedido_productos AS p_p',function($join) use($idPedido){
									$join->on('p_p.id_producto','=','p_v.id_producto');
									$join->where('p_p.id_pedido','=',$idPedido);
								})
							->leftJoin('v_productos_stock AS p_s','p_s.id_producto','=','p_v.id_producto')
							->leftJoin('vendedores_dto_prod AS p_d',function($join) use ($idVendedor){
									$join->on('p_d.id_producto','=','p_v.id_producto');
									$join->where('p_d.id_vendedor','=', $idVendedor);
								})
							->join('vendedores_dto_general AS v_d',function($join) use ($idVendedor){
									$join->where('v_d.id_vendedor','=', $idVendedor);
								})
							->select('p_desc.nombre_comercial','p_desc.url_foto','p_v.*','p_d.descuento AS descuento_producto','p_d.id_vendedor','v_d.descuento AS descuento_Vendedor','p_s.stock_unidades','p_s.stock_kg',
								\DB::raw('(CASE 
											WHEN p_d.descuento>v_d.descuento
											THEN p_d.descuento
											ELSE v_d.descuento
											END) AS dcto_usar'),
								'p_p.cantidad AS cantidad_pedida','p_p.tipo_medida AS medida_pedido','p_p.precio_unitario AS precio_unitario_pedido','p_p.descuento AS descuento_pedido'
								)
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
