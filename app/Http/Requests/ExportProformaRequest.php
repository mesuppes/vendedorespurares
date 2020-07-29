<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportProformaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lastExport'=>'required',
            'sucursal'=>'required', #HARCODEAR-> '0002'
            'facturaAdesde'=>'required',
            'facturaBdesde'=>'required',
            'idProformaHasta'=>'required',
        ];
    }
}
