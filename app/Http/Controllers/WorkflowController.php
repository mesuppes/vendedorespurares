<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use App\WorkflowN;
use DB;
use App\Vendedor;

class WorkflowController extends Controller
{
        static public function agregarPedidoCreate($idVendedor,$idPedido,$requiereAprobacion){ 

    	//1-ID del usuario que lo carga
    	$idUsuario=User::find(Auth::user()->id);

    	//si el rol es vendedor->carga aprobación a rol admnistración
        if ($idUsuario->hasAnyRole('cliente','Gestor_cliente'))      ) {

            $toRole= Role::findByName('Administracion')->id; //administrador
            $toUser=null;
            $actionToDo=4;//aprobar pedido
            $status=1;
        //Si el rol es Vendedor->Cargar WF o saltar Aprob
        }elseif ($idUsuario->hasRole('Administracion')) {
            //Si el campo saltar aprobación no esta tildado
            if ($requiereAprobacion==1) {
                $toRole=null;
                $toUser=Vendedor::find($idVendedor)->id_usuario_vendedor;//Vendedor
                $actionToDo=4;//aprobar pedido
                $status=1;
            }else{  //Si no requiere aprobación->
                $toRole=null;
                $toUser=null;//Vendedor
                $actionToDo=4;//aprobar pedido
                $status=4;//aprobado automáticamente
            }
        }else{
            return 'Error:Se ah registrado un error al asignar el flujo de aprobación';
        }

         //Cargar en la DB
                $insert=WorkflowN::create([
                    'from_user'     =>User::find(Auth::user()->id)->id,
                    'action_done'   =>1,//Agregar Pedido
                    'to_role'       =>$toRole,
                    'to_user'       =>$toUser,
                    'action_todo'   =>$actionToDo,
                    'status'        =>$status,
                    'task_type'     =>1,//pedidos
                    'id_task'       =>$idPedido,
                ]);
    
        return $insert;
    	
    }

    static public function ListaToDoUser($idUsuario){

        //1-Pending por el id_usuario
        //2-pending por los roles que tiene

        //Roles que tiene el usuario
        $rolesUsuario=User::find($idUsuario)->roles->pluck('id')->toArray();

        $listaPending=WorkflowN::whereIn('to_role',$rolesUsuario)
                            ->where('status','=',1) //Pendiente de aprobacion
                        ->orWhere('to_user','=',$idUsuario) 
                            ->where('status','=',1) //Pendiente de aprobacion
                        ->get();

        return $listaPending;
    }



    //-------- ACTUALIZAR --------//

    static public function actualizar($idWF,$newStatus){

    	//Flujo
    	$wf=WorkflowN::find($idWF);
 
    	//0-Ver que el estado siga siendo pendiente
    	if ($wf->status == 1) {
    		$wf->update([
    			'status'	=> $newStatus,
    			'user_done'	=> User::find(Auth::user()->id)->id
    		]);
    		
    		$wf_n=WorkflowController::decodificar(1)->first();
    		$respuesta="El pedido ha sido ". WorkflowController::decodificar(1)->first()->status_n;

    	}else{
    		$respuesta="ERROR - Ya se tomó acción sobre el pedido";
    	}

    	return $respuesta;
    }

	//-------- DECODIFICADOR DE WF --------//


    static public function decodificar($idWF)
    {
    	return DB::table('workflow AS wf')
    		#FROM USER
			->leftjoin('users AS u1','u1.id','=','wf.from_user')
    		#Action Done
    		->leftjoin('option_list AS o1',function($join){
    			$join->on('wf.action_done','=','o1.id_interno');
    			$join->where('o1.filtro','=','WF-action');})
    		#TO ROLE
    		->leftjoin('roles AS r1','r1.id','=','wf.to_role')
    		#TO USER
    		->leftjoin('users AS u2','u2.id','=','wf.to_user')
    		#ACTION TO DO
    		->leftjoin('option_list AS o2',function($join){
    			$join->on('wf.action_todo','=','o2.id_interno');
    			$join->where('o2.filtro','=','WF-action');})
    		#STATUS
    		->leftjoin('option_list AS o3',function($join){
    			$join->on('wf.status','=','o3.id_interno');
    			$join->where('o3.filtro','=','WF-status');})
    		#TASKTYPE
    		->leftjoin('option_list AS o4',function($join){
    			$join->on('wf.task_type','=','o4.id_interno');
    			$join->where('o4.filtro','=','WF-taskType');})
    		#USER DONE
    		->leftjoin('users AS u3','u3.id','=','wf.user_done')

    		->where('wf.id_workflow','=',$idWF)
    		->select('wf.*',
    				'u1.name AS from_user_n',
    				'o1.nombre AS action_done_n',
    				'r1.name AS to_role_n',
    				'u2.name AS to_user_n',
    				'o2.nombre AS action_todo_n',
    				'o3.nombre AS status_n',
    				'o4.nombre AS task_type_n',
    				'u3.name AS user_done_n')
    		->get();
    }

}
