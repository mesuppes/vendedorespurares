<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    protected $table = 'ajustes_inventario';
    protected $guarded=[];//Desactiva la proteccion
    const CREATED_AT = 'fecha_reg';
    const UPDATED_AT = 'fecha_baja';

 	public function productos(){
        return $this->hasMany(ProductoMov::class,'id_ajuste','id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class,'id_usuario_reg','id');
    }

}
