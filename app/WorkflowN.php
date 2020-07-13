<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowN extends Model
{
	protected $table = 'workflow';
	protected $primaryKey ='id_workflow';
	protected $guarded=[];
	const UPDATED_AT = 'date_done';
    const CREATED_AT = 'date_start';

    public function actionDoneN(){
    	return $this->belongsTo(OptionList::class,'action_done','id_interno')
    	->where('filtro','=','WF-action');
    }

    public function toRoleN(){
        return $this->belongsTo(Role::class,'to_role','id');
    }

    public function toUserN(){
        return $this->belongsTo(User::class,'to_user','id');
    }

    public function actionToDoN(){
        return $this->belongsTo(OptionList::class,'action_todo','id_interno')
        ->where('filtro','=','WF-action');
    }

    public function statusN(){
    	return $this->belongsTo(OptionList::class,'status','id_interno')
    	->where('filtro','=','WF-status');
    }


    //ROLE

    //USER

    
}
