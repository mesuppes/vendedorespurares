<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaProforma;
use App\FacturaProformaItem;
use App\Producto;
use App\Vendedor;
use App\ProductoMov;
use App\RptConsumo;



class ReportesController extends Controller
{
    //
	static public function createReporte(){

	    $periodos=false;
	    $datos=false;
	    $clientes=Vendedor::all();

	    return view('rptVentanasMensuales',compact('datos','periodos','clientes'));

	}


    static public function ventas(request $request){

 	   	#return $request;
 	   	#$fechaDesde=$request['fechaDesde'].'-01';
    	#$fechaHasta=$request['fechaHasta'].'-01';
    	#return $fechaDesde;
    	#return $request;

    	#$clientes,$fechaDesde,$fechaHasta
    	#$cliente=[1,59,21];
    	#$fechaDesde='2020-08-01';
    	#$fechaHasta='2020-09-31';
    	$clientes=$request['clientes'];
    	
    	#Buscar todos los periodos
    	$periodos=RptConsumo::where('periodo','>=',$request['fechaDesde'])
    						->where('periodo','<=',$request['fechaHasta'])
    						#->whereIn('id_cliente',$clientes)
    						->distinct('periodo')
    						->pluck('periodo')
							->toArray();

		$a=0;
    	#Ver si es para todos los clientes o si es solo para algunos
		foreach ($clientes as $cliente) {
			$a=$a+1;
			if ($cliente==0) {
				$clientes=Vendedor::all()->pluck('periodo')->toArray();
				break;
			}
		}

		#return $a;

		#Buscar todos los productos para armar la tabla
    	$productos=Producto::all();

    	$datos=[];

    	#Recorro la lista de productos
    	foreach ($productos as $producto) {
    		$valores =[];
			$id=$producto->id_producto;
			$nombre=$producto->nombre_comercial;

			#Recorro la lista de todos los periodos
			foreach ($periodos as $periodo) {
				$cantidad=RptConsumo::where('periodo','=',$periodo)->whereIn('id_cliente',$clientes)->where('id_producto','=',$id)->groupBy('id_producto')->sum('cantidad_kg');

			array_push($valores,$cantidad);

			}
			if (array_sum($valores)>0) {
				array_push($datos, [$id,$nombre,$valores]);
			}

    	}
   	return view('rptVentanasMensuales', compact('datos','periodos'));

    }


}
