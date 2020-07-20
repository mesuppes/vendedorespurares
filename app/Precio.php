<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $table = 'precios';
    protected $primaryKey ='id';
    protected $guarded=[];//Desactiva la proteccion
    const UPDATED_AT = 'fecha_baja';//No existe en la BD
    const CREATED_AT = 'fecha_reg';//No existe en la BD
}
