<?php

namespace App\Imports;

use App\Precio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class PreciosImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Precio([
            'id_producto'   =>$row['id_producto'],
            'precio_kg'     =>$row['precio_kg'],
            'precio_unidad' =>$row['precio_unidad'],
            'fecha_desde'   =>today()->format('Y-m-d'),
            'id_modificacion'=>5,
            'id_usuario_reg'=>Auth::user()->id,
        ]);
    }
}
