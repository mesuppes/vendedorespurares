<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            'nombreProveedor'=>'required'
            #No exista en la BD ese nombre
        ];
    }
}
