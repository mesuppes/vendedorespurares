<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Vendedor;
use App\Producto;
use App\VendedorCredito;
use App\VendedorDescuentoGeneral;
use App\VendedorDescuentoProducto;
use App\User;
use App\Descuento;
use App\Http\Requests\VendedorCreateRequest;
use App\Http\Requests\VendedorDescuentoCreateRequest;
use App\Http\Requests\VendedorUpdateRequest;
use Auth;
use Illuminate\Support\Facades\Hash;

use DB;
use App\Pedido;

class VendedoresController extends Controller
{

    public function index()
    {
        $vendedores=Vendedor::all();

        return view('listaClientes', compact('vendedores'));
    }

    // ---!!! CREAR VENDEDORES !!!--- //

    public function create(){

        return view('agregarVendedor');
    }

    public function edit($id){

        $cliente=Vendedor::find($id);
        return view('editarVendedor',compact('cliente'));
    }

    public function update($id,VendedorUpdateRequest $request){

        Vendedor::find($id)->Update([
            'nombre'           =>$request['nombre'],
            'apellidos'        =>$request['apellido'],
            'telefono1'        =>$request['telefono1'],
            'telefono2'        =>$request['telefono2'],
            'email'            =>$request['email'],
            'tipo_documento'   =>$request['tipoDocumento'],
            'inscripcion_afip' =>$request['inscripcionAfip'],
            'cuit'             =>$request['cuit'],
            'codigo_postal'    =>$request['codigoPostal'],
            'provincia'        =>$request['provincia'],
            'ciudad'           =>$request['ciudad'],
            'direccion'        =>$request['direccion'],
            'id_usuario_reg'   => Auth::user()->id,
        ]);

        return redirect()->route('vendedor.show', $id);
    }

    public function store(VendedorCreateRequest $request)
    {

    //1-Crear Vendedor
        $nuevoVendedor=Vendedor::Create([
            'nombre'          =>$request['nombre'],
            'apellidos'       =>$request['apellido'],
            'telefono1'       =>$request['telfono1'],
            'telefono2'       =>$request['telefono2'],
            'email'           =>$request['email'],
            'tipo_documento'  =>$request['tipoDocumento'],
            'inscripcion_afip'=>$request['inscripcionAfip'],
            'cuit'            =>$request['cuit'],
            'codigo_postal'   =>$request['codigoPostal'],
            'provincia'       =>$request['provincia'],
            'ciudad'          =>$request['ciudad'],
            'direccion'       =>$request['direccion'],
            'id_usuario_reg'  => Auth::user()->id,
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
        $descuentos=Descuento::all();
        $productos=Producto::all();

        return view('asignarDescuentos')->with(compact('vendedor','productos','descuentos'));
    }


    public function storeDescuento(VendedorDescuentoCreateRequest $request){

        //1-DESCUETO GENETAL
        $dg=VendedorDescuentoGeneral::create([
                        'id_vendedor'   =>$request['idVendedor'],
                        'id_descuento'  =>$request['idDescuentoGeneral'],
                        'id_usuario_reg'=>Auth::user()->id,
        ]);

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
                        'descuento'     =>$request['descuentoProducto'][$i]/100,
                        'id_usuario_reg'=>Auth::user()->id,
                    ]);
                }
            }

        return redirect()->route('vendedor.show', $request['idVendedor']);

    #SI SE AVANZA CON CREDITO, SE DEBE USAR ESTA PARTE:
/*        if (Vendedor::find($request['idVendedor'])->credito()->count()>0) {
            return redirect()->route('vendedor.show', $request['idVendedor']);
        }else{
            return redirect()->route('vendedor.createCredito', ['id' => $request['idVendedor']]);
        }*/


    }

    public function show($id){
        //Mostrar el vendedor
        $cliente=Vendedor::find($id);
        
        //Mostrar lista de pedidos 
            $idPedidos=DB::table('pedidos_reg')
                ->selectRaw('MAX(id_pedido) as id')
                ->groupBy('id_pedido_padre')
                ->pluck('id')
                ->toArray();

            $listaPedidos=Pedido::whereIn('id_pedido',$idPedidos)
                                    ->where('id_vendedor','=',$id)
                                    ->orderBy('id_pedido','DESC')
                                    ->get();

        return view('verCliente')->with(compact('cliente','listaPedidos'));
    //Vendedor::find(2)->usuario()->count(); mostrar si tiene usuario
    }

    static public function createUser($id){

        $cliente=Vendedor::find($id);

        //Validar que el mail sea unico
        $Validacion=User::where('email','=',$cliente->email)->count();
        if ($Validacion==0) {
            if (isset($cliente->email) && $cliente->email != "" ) {
                
                //1-Crear Usuario
                $user=User::create([
                    'name' => $cliente->nombre." ".$cliente->apellidos,
                    'email' => $cliente->email,
                    'password' => Hash::make('Purares123'),
                ]);
                
                //2-AsignarRol
                $user->assignRole('Cliente');
                
                //3-Asignar usuario al cliente
                $cliente->update([
                    'id_usuario_vendedor'=>$user->id,
                ]);
                //5-LISTO!
                $respuesta='Usuario generado. Contraseña provisoria: Purares123';
            }else{
                $respuesta='Primero le debe generar un mail al usuario';
                return back()->with('respuesta',$respuesta);                
            }
        }else{
            $respuesta='El mail ya se encuentra registrado';
            return back()->with('respuesta',$respuesta);
        }
        return back()->with('respuesta',$respuesta);
    }

    public function restaurarPassword($id){
        $cliente=Vendedor::find($id);
        User::find($cliente->usuario->id)->Update([
            'password' => Hash::make('Purares123'),
        ]);
    }

    public function showMyProfile(){

        $cliente=Vendedor::where('id_usuario_vendedor','=',Auth::user()->id)->get() ;        
        return view('verMiPerfil')->with(compact('cliente'));  
    }

}
