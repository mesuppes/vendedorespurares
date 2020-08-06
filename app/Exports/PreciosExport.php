<?php

namespace App\Exports;

use App\Producto;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Exportable;

class PreciosExport implements FromQuery , WithHeadingRow
{

	//use Exportable;

    public function headings(): array
    {
        return [
            'id_producto',
            'nombre',
        ];
    }

    public function query()
    {
        return Producto::select('id_producto','nombre_comercial');
    }
}
