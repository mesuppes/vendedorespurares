<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Foo\Bar;

class ProductoView extends Model
{
    protected $table ='v_productos_precios';
    protected $primaryKey = 'id_producto';
}
