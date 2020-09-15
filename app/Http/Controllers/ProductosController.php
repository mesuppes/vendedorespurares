<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\ProductoFabrica;
use App\ProductoMov;
use App\Http\Requests\ProductoCreateRequest;
use Auth;
use Illuminate\Support\Facades\Storage;


class ProductosController extends Controller
{

    public function index()
    {
        $productos=Producto::all();
        return view('listaProductos', compact('productos'));

    }

    public function show($idproducto)
    {
        $producto=Producto::find($idproducto);
        return view('inspeccionarProducto')->with(compact('producto'));
    }

        public function edit($idproducto)
    {
        $producto=Producto::find($idproducto);
            //Productos que se fabrican que no estan asignados
        $productosAsignados=Producto::get()
                        ->where('id_producto_produccion','!=',NULL)
                        ->pluck('id_producto_produccion')
                        ->toArray();
        $ProductoFabrica=ProductoFabrica::whereNotIn('id_producto',$productosAsignados)->get();
        return view('editarProducto')->with(compact('producto','ProductoFabrica'));
    }


    public function create()
    {

        //Productos que se fabrican que no estan asignados
        $productosAsignados=Producto::get()
                        ->where('id_producto_produccion','!=',NULL)
                        ->pluck('id_producto_produccion')
                        ->toArray();

        $ProductoFabrica=ProductoFabrica::whereNotIn('id_producto',$productosAsignados)->get();

        return view('agregarProducto', compact('ProductoFabrica'));
    }

    public function store(ProductoCreateRequest $request)
    {


        $imagen=$request->file('imagen');
        $nombreImagen=$request['nombreComercial'].".".$imagen->getClientOriginalExtension();
        $destino=public_path('uploads/imagenProducto');
        $direccion=$request->imagen->move($destino,$nombreImagen);

        $nuevoProducto=Producto::Create([
            'id_producto_produccion'=>$request['idProductoProduccion'],
            'nombre_comercial'      =>$request['nombreComercial'],
            'url_foto'              =>$nombreImagen,
            'descripcion'           =>$request['descripcion'],
            'peso_unitario'         =>$request['pesoUnitario'],
            'id_usuario_reg'        =>Auth::user()->id,
        ]);

        $producto=Producto::find($nuevoProducto->id_producto);
        return view('inspeccionarProducto',compact('producto'));//agregar succes cartel
    }

    public function Update(ProductoCreateRequest $request)
    {
        $id_producto=$request['idProducto'];
        $imagen=$request->file('imagen');
        $nombreImagen=$request['nombreComercial'].".".$imagen->getClientOriginalExtension();
        $destino=public_path('uploads/imagenProducto');
        $direccion=$request->imagen->move($destino,$nombreImagen);

        $nuevoProducto=Producto::find($id_producto)->update([
            'id_producto_produccion'=>$request['idProductoProduccion'],
            'nombre_comercial'      =>$request['nombreComercial'],
            'url_foto'              =>$nombreImagen,
            'descripcion'           =>$request['descripcion'],
            'peso_unitario'         =>$request['pesoUnitario'],
            'id_usuario_reg'        =>Auth::user()->id,
        ]);

        $producto=Producto::find($nuevoProducto->id_producto);
        return view('inspeccionarProducto',compact('producto'));//agregar succes cartel
    }

    public function movProductos(){

        $movimientos=ProductoMov::orderby('id_movimiento','desc')->paginate(10);

        return view('tablaMovProducto',compact('movimientos'));
    }

    public function stockLote(){

        $productos=Producto::all();
        return view('productoStock')->with(compact('productos'));

    }

}
