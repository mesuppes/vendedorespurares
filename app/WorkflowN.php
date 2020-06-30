<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowN extends Model
{
	protected $table = 'workflow';
	protected $guarded=[];
	const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = 'date_start';//No existe en la BD
}
