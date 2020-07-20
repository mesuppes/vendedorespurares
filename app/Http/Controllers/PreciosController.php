<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Precio;
use App\PrecioV;
use App\Producto;
use App\Http\Requests\PrecioCreateRequest;

class PreciosController extends Controller
{
    

    static public function productoIndividualCreate($idProducto){
        $listaPrecios=PrecioV::find($idProducto);
        return $listaPrecios;
    }

    static public function CargaMasivaCreate(){

        //La vista lista de precios
        $listaPrecios=PrecioV::all();

        //Productos que no estan en la lista de precios
        $productos=$listaPrecios->pluck('id_producto')->toArray();
        $productosSinPrecio=Producto::whereNotIn('id_producto',$productos)->get();

        return view('listaPrecios')->with(compact('productosSinPrecio','listaPrecios'));
    }


    static public function productoIndividualStore(PrecioCreateRequest $request){

        //Validar Fecha
        $validacion=PreciosController::validarFechaDesde($request['idProducto'],$request['fechaDesde']);

        return $request;
        if ($validacion=='ok') {
            //Cargar Precios
            $nuevoPrecio=Precio::create([
                'id_producto'   =>$request['idProducto'],
                'precio_kg'     =>$request['precioKg'],
                'precio_unidad' =>$request['precioUnidad'],
                'fecha_desde'   =>$request['fechaDesde'],
            ]);
            return "Precio actualizado";
        }else{
            return "Error".$validacion;
        }

    }

    static public function cargaMasivaStore(PrecioCreateRequest $request){

        //VALIDAR QUE CUMPLAN CON LOS REQUISITOS
        $longitud=count($request['idProducto']);
        for ($i=0; $i <$longitud ; $i++) { 
            $validacion=PreciosController::validarFechaDesde($request['idProducto'][$i],$request['fechaDesde'][$i]);
            if ($validacion!='ok') {
                return "Error".$validacion;
            }
        }
        //CARCAR EN LA BD

        $idModificacion=(Precio::orderBy('id_modificacion','desc')
                                ->first()
                                ->id_modificacion)
                                +1;
        
        for ($i=0; $i < $longitud ; $i++) { 
            if ($request['precioKg'][$i]>0 && $request['precioUnidad'][$i]>0){
                //Cargar nuevo precio
                $nuevoPrecio=Precio::create([
                    'id_producto'   =>$request['idProducto'][$i],
                    'precio_kg'     =>$request['precioKg'][$i],
                    'precio_unidad' =>$request['precioUnidad'][$i],
                    'fecha_desde'   =>$request['fechaDesde'][$i],
                ]);
            }
        } 
        return "Precio actualizado";
    }

    static public function validarFechaDesde($idProducto,$fechaDesde){

        //Mayor o igual a HOY
        if ($fechaDesde >= today()->format('Y-m-d')) {
            $respuesta='ok';
        }else{
            $respuesta='La fecha debe ser mayor a hoy';
        }
        return $respuesta;
    }


}

