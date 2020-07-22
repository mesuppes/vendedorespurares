<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CompraCreateRequest;
use App\Compra;
use App\Producto;
use App\ProductoMov;

class ComprasController extends Controller
{
    public function index(){

        $listaCompras=Compra::all();

        return view('listaCompras', compact('listaCompras'));
    }


    public function create(){

        //Todos los productos que no se fabrican
        $productos=Producto::where('id_producto_produccion','=',null)->get();

        //nroLote
        $loteCompra=Compra::where('anulado','=',null)->orderBy('lote_compra','desc')->first()->lote_compra +1;

        return view('agregarCompra', compact('productos','loteCompra'));
    }

    public function store(CompraCreateRequest $request){

            //1-ENCABEZADO
        $compra=Compra::create([
            'id_proveedor'  =>$request['idProveedor'],
            'nro_remito'    =>$request['nroRemito'],
            'fecha_compra'  =>$request['fechaCompra'],
            'lote_compra'   =>$request['loteCompra'],
            'comentarios'   =>$request['comentarios'],
            'id_usuario_reg'=>Auth::user()->id,
        ]);


        //2-PRODUCTOS
        $longitud=count($request['idProducto']);
        for ($i=0; $i < $longitud ; $i++) {
            if ($request['unidades']>0) {
                $producto¨=ProductoMov::create([
                   'id_producto'=>$request['idProducto'],
                   'id_compra'  =>$compra->id_compra,
                   'lote_compra'=>$request['loteCompra'],
                   'unidades'   =>$request['unidades'],
                   'peso_kg'    =>$request['peso_kg'],
                   'id_cuenta'     =>2,//Coressponde a la cuenta Compra
                   'id_usuario_reg'=>Auth::user()->id,
                ]);
            }
        }

        return view('verCompra', compact('compra'));
    }


    public function show($id){

        $compra=Compra::find($id);

        return view('verCompra', compact('compra'));
    }

    static public function anular($id){

        $compra=Compra::find($id);
        //1-Verificar si esta anulada
        if ($compra->anulado==1) {
              return "La Compra ya se encuentra anulada";
          }else{
            //2-Anular la compra
            $compra->update([
                'anulado'=>1,
                'id_usuario_baja'=>1,#Auth::user()->id,
            ]);
            //3-Contra asiento de Mov Productos
            $productos=$compra->productos;

            foreach ($productos as $producto) {
                ProductoMov::create([
                   'id_producto'=>$producto->id_producto,
                   'id_compra'  =>$producto->id_compra,
                   'unidades'   =>($producto->unidades)*-1,
                   'peso_kg'    =>($producto->peso_kg)*-1,
                   'id_cuenta'     =>5,//Cuenta-> Anular Compra
                   'id_usuario_reg'=>1,#Auth::user()->id,
                ]);
            }
          }
        return "La compra se ha anulado correctamente";
    }

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
