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
}
