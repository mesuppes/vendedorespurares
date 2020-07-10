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

    public function statusN(){
    	return $this->belongsTo(OptionList::class,'status','id_interno')
    	->where('filtro','=','WF-status');
    }

    public function actionN(){
    	return $this->belongsTo(OptionList::class,'status','id_interno')
    	->where('filtro','=','WF-action');
    }

    //ROLE

    //USER

    
}
