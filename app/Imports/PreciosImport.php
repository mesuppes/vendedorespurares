<?php

namespace App\Imports;

use App\Precio;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class PreciosImport implements ToModel, WithHeadingRow,SkipsOnError,WithValidation
{

    use Importable, SkipsErrors;

    public function model(array $row)
    {
        //Ultimo ID Mod Masiva
        $lastId=Precio::max('id_modificacion');
        $idModificacion=$lastId+1;

        return new Precio([
            'id_producto'   =>$row['id_producto'],
            'precio_kg'     =>$row['precio_kg'],
            'precio_unidad' =>$row['precio_unidad'],
            'fecha_desde'   =>today()->format('Y-m-d'),
            'id_modificacion'=>$idModificacion,
            'id_usuario_reg'=>Auth::user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
             '*.id_producto'      =>['required','exists:productos_descripcion,id_producto'],
             '*.precio_kg'      => ['required','numeric'],
             '*.precio_unidad'  => ['required','numeric'],
        ];
    }



    public function customValidationMessages()
    {
        return [
            '0.2' => 'Valor alterado',
        ];
    }

}
