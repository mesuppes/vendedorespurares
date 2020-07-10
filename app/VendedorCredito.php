<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendedorCredito extends Model
{
    protected $table = 'vendedores_credito';
    protected $primaryKey ='id';
    protected $guarded=[];
    const CREATED_AT = 'fecha_reg';
	const UPDATED_AT = null;
}
