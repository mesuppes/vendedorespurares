<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendedorDescuentoProducto extends Model
{
    protected $table = 'vendedores_dto_prod';
    protected $primaryKey ='id';
    protected $guarded=[];//Desactiva la proteccion
    const UPDATED_AT = 'fecha_act';//No existe en la BD
    const CREATED_AT = 'fecha_reg';//No existe en la BD

    public function producto(){
        return $this->belongsTo(Producto::class,'id_producto','id_producto');
    }
}
