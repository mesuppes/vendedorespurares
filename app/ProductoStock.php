<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoStock extends Model
{
    protected $table ='v_productos_stock';
    protected $primaryKey ='id_producto';
    
}
