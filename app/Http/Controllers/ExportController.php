<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaProforma;
use App\ExportSistema;
use DB;

class ExportController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $proformas=FacturaProforma::where('anulado','=',null)->where('id_export','=',null)->get();
        $lastExport=ExportSistema::orderby('id','desc')->first()->id;

        return view('exportarFacturas', compact('proformas','lastExport'));
    }

    public function store(ExportProformaRequest $request)
    {   


        // 1-Validacion
        $lastExport=ExportSistema::orderby('id','desc')->first()->id;
        if ($lastExport==$request['lastExport'] ) {
            
        }
            // 2-Crear indice EXPORT SISTEMA
            $nroA=$request['facturaAdesde'];
            $nroB=$request['facturaBdesde'];
            
            $export=ExportSistema::create([
                    'factura_a_desde'=>$nroA,
                    'factura_b_desde'=>$nroB,
                    'usuario_reg'=>1,#Auth::user()->id,
            ]);
            // 3-Marcar proformas con el numero fiscal
            $proformasToUpdate=FacturaProforma::where('anulado','=',null)->where('id_export','=',null)->where('id','<=',$request['idProformaHasta'])->get();
            
            #Preparando las variables
            $nroA=$nroA-1;
            $nroB=$nroB-1;
            $idExport=$export->id;
            $sucursal=$request['sucursal'];
            $Qdig=8;#Digitos del numerador de factura

            #Recorrer cada proforma
            foreach ($proformasToUpdate as $proforma) {
                #Determinar si se trata de Fac A-B
                if($proforma->cliente->inscripcion_afip=='RI'){
                    $nroA=$nroA+1;
                    $correlativo=$nroA;
                    $letra='A';
                }else{
                    $nroB=$nroB+1;
                    $correlativo=$nroB;
                    $letra='B';
                }
                #NRO-FISCAL
                $nroFac=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
                $nroFiscal=$letra."-".$sucursal."-".$nroFac;
                
                #cargar Nro Factura Fiscal
                $proforma->update([
                    'id_export' =>$idExport,
                    'nro_fiscal'=>$nroFiscal,
                ]);
            }
            return 'La exportación se realizó con exito';

    }

    public function descargar($id)
    {
        //
        $reg=DB::table('factura_proforma_items AS fp_i')
                    ->join('factura_proforma AS f_p'        ,'f_p.id'           ,'=',   'fp_i.id_factura_proforma')
                    ->join('productos_descripcion AS p_d'   ,'p_d.id_producto'  ,'=',   'fp_i.id_producto')
                    ->where('f_p.id_export','=',$id)
                    ->select(   'p_d.nombre_comercial',

                                'f_p.nro_fiscal',
                                'fp_i.id')
                    ->get();

        return $reg;

    }

    public function destroy($id)
    {
        //
    }
}
