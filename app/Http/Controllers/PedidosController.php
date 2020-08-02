<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests\CrearPedidoRequest;
use App\Http\Requests\ArmarPedidoRequest;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\FacturasController;

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
use App\ProductoMov;
use App\ProductoStock;
use App\ProductoStockLote;



class PedidosController extends Controller
{

	public function index()
	{

		$idPedidos=DB::table('pedidos_reg')
					->selectRaw('MAX(id_pedido) as id')
					->groupBy('id_pedido_padre')
					->pluck('id')
					->toArray();

	    $usuario=Auth::user();

	        if ($usuario->hasRole('Administracion')) { 
	        	#Todos los pedidos
				$listaPedidos=Pedido::whereIn('id_pedido',$idPedidos)->get();

	        }elseif ($usuario->hasRole('Gestor_Cliente')) {
	        	#Los pedidos que tengan su ID en alguno de los pedidos
	        	
	        	$idPedidosPadres=Pedido::where('id_usuario_reg','=',$usuario->id)->pluck('id_pedido_padre')->toArray();
	            $listaPedidos=Pedido::whereIn('id_pedido',$idPedidos)
	            					->whereIn('id_pedido_padre',$idPedidosPadres)
	        						->get();
	        	
	        }elseif ($usuario->hasRole('Cliente')) {
	        	#Los Pedidos que le pertencen al vendedor
	        	$listaPedidos=Pedido::whereIn('id_pedido',$idPedidos)
	        						->where('id_vendedor','=',$usuario->vendedor->id_vendedor)
	        						->get();
	        }

		return view('listaPedidos', compact('listaPedidos'));

	}

	//Se ejecuta el createRouter para determinar si muestra:
		//seleccioón de vendedor ->(para no Vendedores) 
		//La creación de pedido  ->(Vendedores)
	public function createRouter(){

		if (Auth::user()->hasAnyRole('Administracion','Gestor_Cliente')) {
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
		if (Auth::user()->hasAnyRole('Administracion','Gestor_Cliente')) {
			$vendedor=Vendedor::find(request('idVendedor'));
			$productos= producto::all();
			return view('agregarPedido')->with(compact('productos','vendedor'));
		
		}elseif (Auth::user()->hasRole('Cliente')) {
			$vendedor=User::find(Auth::user()->id)->vendedor;
			$productos=producto::all();
			return view('agregarPedido')->with(compact('productos','vendedor'));
		}else{
			return "ERROR - Su rol no permite realizar la operación";
		}}

	public function store(CrearPedidoRequest $request){
		
		//return $request;

		//VALIDAR STOCK
		$validarStock=PedidosController::validarStockPedido($request['idProducto'],$request['tipoMedida'],$request['cantidad']);
		if ($validarStock!='ok') {
			return $validarStock;
		}

	//VALIDAR CRÉDITO

				#!!!PENDIENTE!!!
				#!!!PENDIENTE!!!
				#!!!PENDIENTE!!!

	//CREAR PEDIDO
		$nuevoPedido= Pedido::create([
			'id_pedido_padre'=>$request['idPedidoPadre'],
			'id_vendedor'   =>$request['idVendedor'],
			'forma_entrega' =>$request['formaEntrega'],
			'datos_flete'   =>$request['datosFlete'],
			'condicion_pago'=>$request['condicionPago'],
			'comentarios'	=>$request['comentarios'],
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

	static public function show($id){

		$usuario=Auth::user();
		#PERMISOS PARA VERLO
		if($usuario->hasRole('Administracion') || #Si tiene el rol Admin
			PedidosController::canView($id)){ #Si esta dentro de los que el usuario gestiono

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
						->orderBy('id_workflow','desc')
						->first();
			
	 
			$ok=WorkflowController::ListaToDoUserQuery()->pluck('id_workflow')->toArray();
			
			if (in_array($wf->id_workflow, $ok)) {
				$accion='si';
			}else{ 
				$accion='no';
			}
			
			$msjStatus=PedidosController::statusMensaje($wf->id_workflow);

			$facturaProforma=$pedidoDescUltimo->facturaProforma()->where('anulado','=',null)->first();

			if ($facturaProforma!=null) {
				$idFacturaProforma=$facturaProforma->id;
			}else{
				$idFacturaProforma=null;
			}


			return view('inspeccionarPedido')->with(compact('pedidoDescUltimo','pedidoProdUltimo','pedidoDescAnterior','pedidoProdAnterior','wf','msjStatus','accion','idFacturaProforma'));
		}else{
			return 'no permisos para acceder ';
		}

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

	static public function rechazar($idPedido){
		
		//1-VALIDAR QUE SIGA PENDIENTE
			$wf=WorkflowN::where('task_type','=',1)->where('id_task','=',$idPedido)->orderBy('id_workflow','desc')->first();

			if(isset($wf->user_done)){
				return "El pedido ya se ha ".$wf->statusN->nombre." por ".$wf->userDoneN->name;
			}

		//2-ANULAR!!
			$wfNew=WorkflowController::rechazarPedido($wf->id_workflow);
			//agregar Motivo del rechazo
			$pedido=Pedido::find($wf->id_task)->update([
						'motivo_baja'=>request('motivoBaja'),
						]);
		return back();
	}


		/// -------------ARMAR PEDIDOS------------- ///

	static public function armarPedidoCreate($idPedido){

		$pedido=Pedido::find($idPedido);
		
		return view('armarPedido')->with(compact('pedido'));

	}

	public function armarPedidoStore(ArmarPedidoRequest $request){


	//VALIDAR QUE SIGA PENDIENTE
		$wf=WorkflowN::where('task_type','=',1)->where('id_task','=',$request['idPedido'])->orderBy('id_workflow','desc')->first();

		if(isset($wf->user_done)){
			return "El pedido ya se ha ".$wf->statusN->nombre." por ".$wf->userDoneN->name;
		}		
	//VALIDAR STOCK

		$validarStock=PedidosController::validarStockFactura($request['idProducto'],
															$request['cantidadUnidades'],
															$request['cantidadKg'],
															$request['loteProduccion'],
															$request['loteCompra']);
		if ($validarStock!='ok') {
			return $validarStock;
		}


	$idVendedor=Pedido::find($request['idPedido'])->id_vendedor;

	$productosTabla=PedidosController::tablaDatosProductosOP($request['idPedido']);

	//GENERAR FACTURA PROFORMA
		
		$nuevaFactura= FacturaProforma::create([
			'id_cliente'	=>$idVendedor,
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

				#DETERMINAR QUE PRECIO UTILIAR(UNIDAD/KG)
				if ($request['tipoMedida'][$i]=='Unidades') {
					$cantidad=$request['cantidadUnidades'][$i];
						$precio=$request['precio'][$i];
						$descuento=$request['descuento'][$i];
				}elseif ($request['tipoMedida'][$i]=='kg') {
					$cantidad=$request['cantidadKg'][$i];
						$precio=$request['precio'][$i];
						$descuento=$request['descuento'][$i];
				}
				

				#INSERT DB ITEM DE FACTURA PROFORMA 
				$nuevoItem=FacturaProformaItem::create([
					'id_factura_proforma'=>$idFactura,
					'id_producto'		=>$request['idProducto'][$i],
					'lote_produccion'	=>$request['loteProduccion'][$i],
					'lote_compra'		=>$request['loteCompra'][$i],	
					'cantidad_unidades'	=>$request['cantidadUnidades'][$i],
					'cantidad_kg'		=>$request['cantidadKg'][$i],
					'tipo_unidad'		=>$request['tipoMedida'][$i],
					'precio_unitario'	=>$precio,
					'descuento'			=>($precio*$cantidad)*$descuento,
					'precio_total'		=>($precio*$cantidad)*(1-$descuento),
				]);
				#INSERTAR MOVIMIENTO DE PRODUCTOS
				$movProducto=ProductoMov::create([
					'id_producto'		=>$nuevoItem->id_producto,
					'id_factura_proforma'=>$nuevoItem->id_factura_proforma,
					'id_compra'			=>null,
					'id_ordenprod'		=>null,
					'lote_produccion'	=>$nuevoItem->lote_compra,
					'lote_compra'		=>$nuevoItem->lote_produccion,
					'unidades'			=>($nuevoItem->cantidad_unidades)*-1,
					'peso_kg'			=>($nuevoItem->cantidad_kg)*-1,
					'id_cuenta'			=>1,
					'id_usuario_reg'	=>Auth::user()->id,
				]);
			}
		}

		//Cambiar estado de wf
		$newWf=WorkflowController::armarPedido($wf->id_workflow);

		$factura=FacturaProforma::find($idFactura);   
        return view('inspeccionarFacturaProforma', compact('factura'));

	}	

	static public function canView($idPedido){
		//1-Buscar pedidos hijo del mismo padre
			#Pedido Padre
			$pPadre=Pedido::find($idPedido)->id_pedido_padre;
			#Pedidos Hijo
			$pHijos=Pedido::where('id_pedido_padre','=',$pPadre)->pluck('id_pedido')->toArray();
		//2-Todos los usuarios que estuvieron dentro del WF
			$wfs=WorkflowN::whereIn('id_task',$pHijos)->get();
				$idUserFrom=$wfs->pluck('from_user')->toArray();
				$idUserTo=$wfs->pluck('to_user')->toArray();
		//3-Usuario del vendedor		
				$vendedor=Pedido::find($idPedido)->vendedor;
				$usuarioVendedor=$vendedor->usuario->pluck('id')->toArray();

		//4-Verificar si el rol del usario esta dentro de estos array
				$usersCan=array_merge($idUserFrom,$idUserTo,$usuarioVendedor);

		#busca si el usuario logueado esta detro del array armado
		#return in_array(7,$usersCan);
		return in_array(Auth::user()->id,$usersCan);

	}		


	public function validarStockPedido($productos,$tipoMedida,$cantidad){
		
		$longitud=count($productos);
		$stockProductos=ProductoStock::all();
			
			for ($i=0; $i <$longitud ; $i++) { 
				//Cantidad Mayor a cero
				if ($cantidad[$i]>0) {
					//Tipo de Medida
					if ($tipoMedida[$i]=='kg') {
						$Stock=$stockProductos->find($productos[$i])->stock_kg;		 	
					}else{
					 	$Stock=$stockProductos->find($productos[$i])->stock_unidades;
					} 
					//VALIDACION
					if ($Stock<$cantidad[$i]) {
						$mensaje="ERROR- Stock insuficiente de ".Producto::find($productos[$i])->nombre_comercial;
						return  $mensaje;
					}
				}
			}
		return "ok";
	}

	public function validarStockFactura($idProducto,$cantidadUnidades,$cantidadKg,$loteProduccion,$loteCompra){
		
		$longitud=count($idProducto);
		$stockProductosLote=ProductoStockLote::all();
			
			for ($i=0; $i <$longitud ; $i++) { 
				//Cantidad Mayor a cero
				if ($cantidadKg[$i]>0 && $cantidadUnidades[$i]>0) {
					#1)
					//Buscar en Lote de **PRODUCCION**	
					if(isset($loteProduccion[$i])){
						$productoLote=$stockProductosLote
											->where('id_producto','=',$idProducto[$i])
											->where('lote_produccion','=',$loteProduccion[$i])
											->first();
						$lote="produccion: ".$loteProduccion[$i];
					//Buscar en Lote de **COMPRA**
					}elseif (isset($loteCompra[$i])) {
						$productoLote=$stockProductosLote
											->where('id_producto','=',$idProducto[$i])
											->where('lote_compra','=',$loteCompra[$i])
											->first();
						$lote="compra: ".$loteCompra[$i];
						#return $productoLote;
					}else{
						return "ERROR - lote no definido para el producto ".
						Producto::find($idProducto[$i])->nombre_comercial;
					}#if lotes
					
					#2)
					if (isset($productoLote)) { #Si no figura el IdProducto+Lote => no esta seteado
						if ($productoLote->stock_kg < $cantidadKg[$i] ||
							$productoLote->stock_unidades < $cantidadUnidades[$i]) {

								return "ERROR - Stock insuficiente ".
									Producto::find($idProducto[$i])->nombre_comercial.
									" - Lote ". $lote;
						}#if Stock
					}else{
						return "ERROR - Stock insuficiente ".
									Producto::find($idProducto[$i])->nombre_comercial.
									" - Lote ". $lote;
					}#if lote nulo
				}#if Q>0
			}#for
		
		return "ok";
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

		//se usa para armar el pedido 

		$idVendedor=Pedido::find($idPedido)->id_vendedor;

		$productosTabla=DB::table('v_productos_precios AS p_v')
							->join('productos_descripcion AS p_desc','p_desc.id_producto','=','p_v.id_producto')
							->leftJoin('pedido_productos AS p_p',function($join) use($idPedido){
									$join->on('p_p.id_producto','=','p_v.id_producto');
									$join->where('p_p.id_pedido','=',$idPedido);
								})
							->leftJoin('v_productos_stock_lotes AS p_s','p_s.id_producto','=','p_v.id_producto')
							->leftJoin('vendedores_dto_prod AS p_d',function($join) use ($idVendedor){
									$join->on('p_d.id_producto','=','p_v.id_producto');
									$join->where('p_d.id_vendedor','=', $idVendedor);
								})
							->join('vendedores_dto_general AS v_d',function($join) use ($idVendedor){
									$join->where('v_d.id_vendedor','=', $idVendedor);
								})
							->select('p_desc.nombre_comercial','p_desc.url_foto','p_v.*','p_d.descuento AS descuento_producto','p_d.id_vendedor','v_d.descuento AS descuento_Vendedor','p_s.stock_unidades','p_s.stock_kg','p_s.lote_produccion','p_s.lote_compra',
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
