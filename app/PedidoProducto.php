<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    protected $table ='pedido_productos';
    protected $guarded=[];
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = null;//No existe en la BD

}
