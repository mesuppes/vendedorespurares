<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class Workflow extends Controller
{
    public function agregarPedido(){

    	//1-ID del usuario que lo carga
    	$idUsuario=User::find(Auth::user()->id);

    	//2-Rol del usuario que lo cara
        
        administrador($idUsuario->hasRole('vendedor')) {
            $toRole=;
            $toUser=null;
            $actionToDo=;
            $status=1;
            $taskType=;
        }elseif ($idUsuario->hasRole('Administracion')) {
            # code...
        }else{
            'Error:Se ah registrado un error al asignar el flujo de aprobación'
        }

    	//3-Si el permiso es: Pedidos_Vendedor
    		//WF: Pendiente Aprobación -> Administracion PR
    	//4-Si el permiso es:Pedidos_Administrador
    		//Requiere aprobacion=NO
    			//Cargar WF Finaliado

         //Cargar en la DB
                Workflow::create([
                    'from_user'=>$idUsuario,
                    'action_done'=>1,
                    'to_role'=>,
                    'to_user'=>,
                    'action_todo'=>,
                    'status'=>,
                    'task_type'=>,
                    'id_task'=>,
                ]);



    }

}
