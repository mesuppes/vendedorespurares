<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaProformaItem extends Model
{
    protected $table ='factura_proforma_items';
    protected $guarded=[];
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = fecha_reg;//No existe en la BD
}

	public function producto(){
        return $this->belongsTo(Producto::class,'id_producto','id_producto');
    }