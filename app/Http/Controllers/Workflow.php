<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class Workflow extends Controller
{
    public function agregarPedidoCreate($idVendedor,$idPedido){

        //[TO DO] !!!!
        //->DEFINIR ROL VENDEDOR
        //->DEFINIR ROL ADMINISTRADOR
        //->COMO ENVIAR EL ERROR

        #CrearPedido
        #EditarPedido

    	//1-ID del usuario que lo carga
    	$idUsuario=User::find(Auth::user()->id);

    	//si el rol es vendedor->carga aprobación a rol admnistración
        if ($idUsuario->hasRole('Vendedor')) {
            
            $toRole= Role::findByName('Administracion')->id; //administrador
            $toUser=null;
            $actionToDo=4;//aprobar pedido
            $status=1;
        //Si el rol es Vendedor->Cargar WF o saltar Aprob
        }elseif ($idUsuario->hasRole('Administracion')) {
            //Si el campo saltar aprobación no esta tildado
            if ($saltarAprobacion!=1) {
                
                $toRole=null; 
                $toUser=$Vendedor::find($idVendedor)->id_usuario_vendedor;//Vendedor
                $actionToDo=4;//aprobar pedido
                $status=1;
            }else{  //Si no requiere aprobación->
                $toRole=null; 
                $toUser=null;//Vendedor
                $actionToDo=4;//aprobar pedido
                $status=4;//aprobado automáticamente
            }
        }else{
            'Error:Se ah registrado un error al asignar el flujo de aprobación'
        }

         //Cargar en la DB
                Workflow::create([
                    'from_user'     =>$idUsuario,
                    'action_done'   =>1,//Agregar Pedido
                    'to_role'       =>$toRole,
                    'to_user'       =>$toUser,
                    'action_todo'   =>$actionToDo,
                    'status'        =>$status,
                    'task_type'     =>1,//pedidos
                    'id_task'       =>$idPedido,
                ]);
    }
        return $workflow = array('status'   =>$status,
                                'toRole'    =>$toRole,
                                'actionTodo'=>$actionToDo);

}
