<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PrecioV;
use App\Producto;

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

        return $productosSinPrecio;

        //PARA EL FRONT
        #$PreciosFuturos=PrecioV::find(1)->producto->precio()->where('fecha_desde','>','')->get();

    }


    static public function productoIndividualStore(PrecioCreateRequest $request){


        $nuevoPrecio=Precio::create([
            'id_producto'   =>$request['idProducto'],
            'precio_kg'     =>$request['precioKg'],
            'precio_unidad' =>$request['precioUnidad'],
            'fecha_desde'   =>$request['fechaDesde'],
        ]);

    return "Precio actualizado";
    }

    static public function cargaMasivaStore(PrecioCreateRequest $request){

        $idModificacion=(Precio::orderBy('id_modificacion','desc')
                                ->first()
                                ->id_modificacion)
                                +1;

        $longitud=count($request['idProducto']);
        
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
}

