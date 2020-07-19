<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendedor;
use App\Producto;
use App\VendedorCredito;
use App\VendedorDescuentoGeneral;
use App\VendedorDescuentoProducto;
use App\Http\Requests\VendedorCreateRequest;
use App\Http\Requests\VendedorDescuentoCreateRequest;
use Auth;

class VendedoresController extends Controller
{
   
    public function index()
    {
        $vendedores=Vendedor::get();

        return view('listaClientes', compact('vendedores'));
    }

    // ---!!! CREAR VENDEDORES !!!--- //

    public function create()
    {
        return view('agregarVendedor');
    }

    public function update($id)
    {
        
        Vendedor::find($id)->Update([
            'nombre'    =>$request['nombre'],
            'apellidos'  =>$request['apellido'],
            'telefono1'  =>$request['telfono1'],
            'telefono2' =>$request['telefono2'],
            'email'     =>$request['email'],
            'cuit'      =>$request['cuit'],
            'provincia' =>$request['provincia'],
            'ciudad'    =>$request['ciudad'],
            'direccion' =>$request['direccion'],
            'id_usuario_reg'=> Auth::user()->id,
        ]);

        return redirect()->route('vendedor.show', $id);
    }

    public function store(VendedorCreateRequest $request)
    {

    //1-Crear Vendedor
        $nuevoVendedor=Vendedor::Create([
            'nombre'    =>$request['nombre'],
            'apellidos'  =>$request['apellido'],
            'telefono1'  =>$request['telfono1'],
            'telefono2' =>$request['telefono2'],
            'email'     =>$request['email'],
            'cuit'      =>$request['cuit'],
            'provincia' =>$request['provincia'],
            'ciudad'    =>$request['ciudad'],
            'direccion' =>$request['direccion'],
            'id_usuario_reg'=> Auth::user()->id,
        ]);

    //2-Crear descuentos para vendedor
        $idNuevoVendedor=$nuevoVendedor->id_vendedor;

		return redirect()->route('vendedor.createDescuento', ['id' => $idNuevoVendedor]);

    }

    // ---!!! CREDITOS !!!--- //

    public function createCredito($idVendedor){


        $vendedor=Vendedor::find($idVendedor);

        return view('asignarCredito')->with(compact('vendedor'));
    }

    public function storeCredito(){

        VendedorCredito::create([
            'id_vendedor'=>request('idVendedor'),
            'monto'=>request('monto'),
            'id_usuario_reg'=>Auth::user()->id,
            ]);
        $id_vendedor=request('idVendedor');

        return redirect()->route('vendedor.show', ['id' => $id_vendedor]);

    }

    // ---!!!DESCUENTOS !!!--- //

    public function createDescuentos($idVendedor){

        $vendedor=Vendedor::find($idVendedor);
        $productos=Producto::all();

        return view('asignarDescuentos')->with(compact('vendedor','productos'));
    }


    public function storeDescuento(VendedorDescuentoCreateRequest $request){

        //1-DESCUETO GENETAL

        #Buscar descuento
        $DescuentoGeneral=VendedorDescuentoGeneral::where('id_vendedor','=',$request['idVendedor']);

         if (count($DescuentoGeneral->get()) == null) {
        //NO EXISTE->Guardar el descuento General
            $dg=VendedorDescuentoGeneral::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'descuento'     =>$request['descuentoGeneral'],
                        'id_usuario_reg'=>Auth::user()->id,
            ]);
         }else{
        //EXISTE->actualizar el descuento General
            $dg=$DescuentoGeneral->update([
                        'id_vendedor'   =>$request['idVendedor'],
                        'descuento'     =>$request['descuentoGeneral'],
                        'id_usuario_act'=>Auth::user()->id,
            ]);
        }

        //2-DESCUENTO POR PRODUCTO
            #Eliminar descuentos por productos viejos
            VendedorDescuentoProducto::where('id_vendedor','=',$request['idVendedor'])->delete();
            #Guardar el descuento por Producto
            $longitud=count($request['idProducto']);
            for ($i=0; $i <$longitud ; $i++) {
                if ($request['descuentoProducto'][$i]>0) { //Guardar solo si es mayor a cero
                    VendedorDescuentoProducto::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'id_producto'   =>$request['idProducto'][$i],
                        'descuento'     =>$request['descuentoProducto'][$i],
                        'id_usuario_reg'=>Auth::user()->id,
                    ]);
                }
            }
       
        if (Vendedor::find($request['idVendedor'])->credito()->count()>0) {
            return redirect()->route('vendedor.show', $request['idVendedor']);
        }else{
            return redirect()->route('vendedor.createCredito', ['id' => $request['idVendedor']]);
        }        

    }

    public function show($id)
    {
        //Mostrar el vendedor
        $cliente=Vendedor::find($id);
        return view('verCliente')->with(compact('cliente'));

    }

}
