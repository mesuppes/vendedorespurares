<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table ='productos_descripcion';

    public function stock(){
        return $this->belongsTo(Stockproducto::class,'id_producto_produccion','id_producto');
    }
}
