<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoStockLote extends Model
{
    protected $table ='v_productos_stock_lotes';
    protected $primaryKey ='id_producto';
}
