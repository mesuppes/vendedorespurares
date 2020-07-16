<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecioV extends Model
{
    protected $table ='v_productos_precios';
    protected $primaryKey ='id_producto';
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = null;//No existe en la BD

    public function producto(){
        return $this->belongsTo(Producto::class,'id_producto','id_producto');
    }

}
