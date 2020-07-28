<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaProforma extends Model
{
    protected $table ='factura_proforma';
    protected $guarded=[];
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = 'fecha_reg';//No existe en la BD

	public function productos(){
    	return $this->hasMany(FacturaProformaItem::class,'id_factura_proforma','id');
    }

    public function cliente(){
    	return $this->belongsTo(Vendedor::class,'id_cliente','id_vendedor');
    }

    public function pedido(){
    	return $this->belongsTo(Pedido::class,'id_pedido','id_pedido');
    }
}