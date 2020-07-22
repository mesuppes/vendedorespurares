<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AjusteInventarioCreateRequest;
use App\AjusteInventario;
use App\Producto;
use App\ProductoMov;
use App\ProductoStockLote;

class AjustesInventarioController extends Controller
{
    public function index(){

        $listaAjusteInventario=AjusteInventario::all();

        return view('listaAjusteInventario', compact('listaAjusteInventario'));
    }


    public function create(){

        //Todos los productos que no se fabrican
        $productosLote=ProductoStockLote::all();

        return view('agregarAjusteInventario', compact('productosLote'));
    }

    public function store(AjusteInventarioCreateRequest $request){

            //1-ENCABEZADO
        $ajuste=AjusteInventario::create([
            'motivo'        =>$request['comentarios'],
            'id_usuario_reg'=>Auth::user()->id,
        ]);

        //2-PRODUCTOS
        $longitud=count($request['idProducto']);
        for ($i=0; $i < $longitud ; $i++) {
            if ($request['unidades']>0) {
                $producto¨=ProductoMov::create([
                   'id_producto'    =>$request['idProducto'],
                   'id_ajuste'      =>$ajuste->id,
                   'lote_produccion'=>$request['lote_produccion'],
                   'lote_compra'    =>$request['loteCompra'],
                   'unidades'       =>$request['unidades'],
                   'peso_kg'        =>$request['peso_kg'],
                   'id_cuenta'      =>7,//Coressponde a la cuenta Compra
                   'id_usuario_reg' =>Auth::user()->id,
                ]);
            }
        }

        return view('verAjuste', compact('ajuste'));
    }


    public function show($id){

        $ajuste=Compra::find($id);

        return view('verAjuste', compact('ajuste'));
    }

    static public function anular($id){

        $ajuste=AjusteInventario::find($id);
        //1-Verificar si esta anulada
        if ($ajuste->anulado==1) {
              return "El ajuste ya se encuentra anulado";
          }else{
            //2-Anular la compra
            $ajuste->update([
                'anulado'=>1,
                'id_usuario_baja'=>1,#Auth::user()->id,
            ]);
            //3-Contra asiento de Mov Productos
            $productos=$ajuste->productos;

            foreach ($productos as $producto) {
                ProductoMov::create([
                   'id_producto'    => $producto->id_producto,
                   'lote_produccion'=> $producto->lote_produccion,
                   'lote_compra'    => $producto->loteCompra,
                   'unidades'       =>($producto->unidades)*-1,
                   'peso_kg'        =>($producto->peso_kg)*-1,
                   'id_cuenta'      => 5,//Cuenta-> Anular Compra
                   'id_usuario_reg' => 1,#Auth::user()->id,
                ]);
            }
          }
        return "El ajuste".$id."anulado correctamente";
    }



///  ESTA PARTE DE PROVEEDORES NO SE AVANZO. ACTUALMENTE SE INGRESA EL NOMBRE, NO TIENE LISTA DESPLEGABLE


    //AGREGAR UN PROVEEDOR (SOLO AGREGA EL NOMBRE) -> Ventana emergente

    public function createProveedor(){

        return 1; //tiene que abrir una ventanita emergente para poner el nombre del proveedor
    }

    public function storeProveedor(ProveedorCreateRequest $request){

        $lastId= OptionList::where('filtro','=','WF-action')->orderBy('id_interno','desc')->first()->id_interno;
            $proveedor=OptionList::create([
                'id_interno'=>$lastId+1,
                'nombre'=>$request['nombreProveedor'],
                'filtro'=>'Proveedores',
            ]);
    }


}
