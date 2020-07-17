<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\ProductoFabrica;


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

        return view('inspeccionarProducto')->with(compact(producto));

    }    




    public function create()
    {
        
        //Productos que se fabrican que no estan asignados
        $productosAsignados=Producto::get()->pluck('id_producto_produccion')->toArray();
        $ProductoFabrica=ProductoFabrica::whereNotIn('id_product',$productosAsignados)->get();
        
        return view('crearProducto', compact('ProductoFabrica'))
    }

    public function store(ProductoCreateRequest $request)
    {
        
        $nuevoProducto=Producto::Create([
            'id_producto_produccion'=>$request['idProductoProduccion'],
            'nombre_comercial'      =>$request['nombreComercial'],
            'url_foto'              =>$request['urlFoto'],
            'descripcion'           =>$request['descripcion'],
            'peso_unitario'         =>$request['pesoUnitario'],
            'id_usuario_reg'        =>Auth::user()->id,
        ]);
        
        $id=$nuevoProducto->id_producto;
        return view('inspeccionarProducto')->with(id);//agregar succes cartel
    }

    public function Update(ProductoCreateRequest $request,$id_producto)
    {
        
        $nuevoProducto=Producto::find($id_producto)->update([
            'id_producto_produccion'=>$request['idProductoProduccion'],
            'nombre_comercial'      =>$request['nombreComercial'],
            'url_foto'              =>$request['urlFoto'],
            'descripcion'           =>$request['descripcion'],
            'peso_unitario'         =>$request['pesoUnitario'],
            'id_usuario_reg'        =>Auth::user()->id,
        ]);
        
        $id=$nuevoProducto->id_producto;
        return view('inspeccionarProducto')->with(id);//agregar succes cartel
    }    
    
}
