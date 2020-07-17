<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras_reg';
    protected $primaryKey ='id_compra';
    protected $guarded=[];//Desactiva la proteccion
    const CREATED_AT = 'fecha_reg';//No existe en la BD
    const UPDATED_AT = 'fecha_baja';

	public function proveedorN(){
    	return $this->belongsTo(OptionList::class,'id_proveedor','id_interno')
    	->where('filtro','=','Proveedores');
    }

    public function productos(){
        return $this->hasMany(ProductoMov::class,'id_compra','id_compra');
    }

}
