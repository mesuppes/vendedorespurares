<?php

namespace App\Exports;

use App\Producto;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PreciosExport implements FromQuery , WithHeadings,ShouldAutoSize
{

	use Exportable;

    public function query()
    {
        return Producto::select('id_producto','nombre_comercial');
    }

    public function headings(): array
    {
        return [
            'id_producto',
            'nombre',
            'precio_kg',
            'precio_unidad',
        ];
    }

}
