<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendedorDescuentoGeneral extends Model
{
    protected $table = 'vendedores_dto_general';
    protected $primaryKey ='id';
    protected $guarded=[];
    const CREATED_AT = 'fecha_reg';
	const UPDATED_AT = 'fecha_act';

	public function descuento(){
        return $this->belongsTo(descuento::class,'id','id');
    }


}

