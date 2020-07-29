<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportSistema extends Model
{
    protected $table ='export_sistemas';
    protected $guarded=[];
    const UPDATED_AT = 'fecha_baja';//No existe en la BD
    const CREATED_AT = 'fecha_reg'; //No existe en la BD
}
