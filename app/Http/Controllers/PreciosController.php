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

            //Cargar Precios
            $nuevoPrecio=Precio::create([
                'id_producto'   =>$request['idProducto'][0],
                'precio_kg'     =>$request['precioKg'][0],
                'precio_unidad' =>$request['precioUnidad'][0],
                'fecha_desde'   =>today()->format('Y-m-d'),
            ]);
            return PreciosController::CargaMasivaCreate();
    }

    static public function cargaMasivaStore(PrecioCreateRequest $request){
        

        $lastId=Precio::orderBy('id_modificacion','desc')
                                ->first()
                                ->id_modificacion;
        
        if (isset($lastId)==1) {
            $idModificacion=$lastId+1;
        }else{
            $idModificacion=1;
        }
        
        $longitud=count($request['idProducto']);
        for ($i=0; $i < $longitud ; $i++) { 
            #if ($request['precioKg'][$i]!=null && $request['precioUnidad'][$i]!=null){
            if ((isset($request['precioKg'][$i])==1) && 
                (isset($request['precioUnidad'][$i])==1)) {    
                
                //return $request['idProducto'][$i];
                //Cargar nuevo precio
                $nuevoPrecio=Precio::create([
                    'id_producto'   =>$request['idProducto'][$i],
                    'precio_kg'     =>$request['precioKg'][$i],
                    'precio_unidad' =>$request['precioUnidad'][$i],
                    'fecha_desde'   =>today()->format('Y-m-d'),
                    'id_modificacion'=>$idModificacion,
                ]);
            }
        } 
        return PreciosController::CargaMasivaCreate();
    }

}

