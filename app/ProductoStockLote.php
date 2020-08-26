<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoStockLote extends Model
{
    protected $table ='v_productos_stock_lotes';
    protected $primaryKey ='id_producto';

	public function producto(){
        return $this->belongsTo(Producto::class,'id_producto','id_producto');
    }

}
