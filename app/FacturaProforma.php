<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaProforma extends Model
{
    protected $table ='factura_proforma';
    protected $guarded=[];
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = 'fecha_reg';//No existe en la BD

	public function item(){
    	return $this->hasMany(FacturaProformaItem::class,'id_factura_proforma','id');
    }
}