<?php

namespace App\Imports;

use App\Precio;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class PreciosImport implements ToModel, WithHeadingRow,WithValidation
{


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

    public function rules(): array
    {
        return [
             '*.precio_kg'      => 'required',
             '*.precio_kg'      => 'required',
             '*.precio_unidad'  => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.2' => 'Valor alterado',
        ];
    }

}
