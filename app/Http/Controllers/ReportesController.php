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
    static public function ventas(){

    	#$clientes,$fechaDesde,$fechaHasta
    	$cliente=[1,59,21];
    	$fechaDesde='2020-08-01';
    	$fechaHasta='2020-09-31';

    	$periodos=RptConsumo::where('fecha_reg','>=',$fechaDesde)
    						->where('fecha_reg','<=',$fechaHasta)
    						#->whereIn('id_cliente',$clientes)
    						->distinct('periodo')
    						->pluck('periodo')
							->toArray();

    	$productos=Producto::all();

    	$datos=[];

    	#Recorro la lista de productos
    	foreach ($productos as $producto) {
    		$valores =[];
			$id=$producto->id_producto;
			$nombre=$producto->nombre_comercial;

			#Recorro la lista de todos los periodos
			foreach ($periodos as $periodo) {
				$cantidad=RptConsumo::where('periodo','=',$periodo)->whereIn('id_cliente',$cliente)->where('id_producto','=',$id)->groupBy('id_producto')->sum('cantidad_kg');

			array_push($valores,$cantidad);

			}
			if (array_sum($valores)>0) {
				array_push($datos, [$id,$nombre,$valores]);
			}

    	}
   	return view('rptVentanasMensuales', compact('datos','periodos'));

    }

static public function createReporte(){

    $periodos=false;
    $datos=false;
    return view('rptVentanasMensuales',compact('datos','periodos'));

}

}
