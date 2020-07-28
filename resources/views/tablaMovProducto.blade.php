@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

   <div class="content">
        <div class="row">
            <div class="col-md-12 pl-1 pr-1">
                <div class="bg-white card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Movimiento de Productos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table"  id="dt-mant-table">
                                <thead>
                                    <tr>
                                        <th>idMov</th>
                                        <th>Producto</th>
                                        <th>Fecha</th>
                                        <th>Lote</th>
                                        <th>Usuario</th>
                                        <th>Unidades</th>
                                        <th>Kg</th>
                                        <th>Cuenta</th>
                                        <th>N° Factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($movimientos as $movimiento)
                                    <tr>
                                        <td>{{$movimiento->id_movimiento}}</td>
                                        <td>{{$movimiento->producto->nombre_comercial}}</td>
                                        <td>{{$movimiento->fecha_reg->formatLocalized('%d/%m/%Y - %H:%M')}}</td>
                                        <!--LOTE -->
                                        <td>
                                                @if(isset($movimiento->lote_produccion))
                                                    P-{{$movimiento->lote_produccion}}
                                                @endif

                                                @if(isset($movimiento->lote_compra))
                                                    C-{{$movimiento->lote_compra}}
                                                @endif
                                        </td>
                                        <td>{{$movimiento->usuario->name}}</td>
                                        <td>{{$movimiento->unidades}}</td>
                                        <td>{{$movimiento->peso_kg}}</td>
                                        <td>{{$movimiento->cuenta->nombre}}</td>
                                        <td>{{$movimiento->id_factura_proforma}}</td>
                                    </tr>
                                    @empty
									No existen Movimientos
									@endforelse
                                </tbody>
                                <tfoot>
</tfoot>
                            </table>

                            {{$movimientos->links()}}
                        </div>
                    </div>
                </div>
	        </div>
	    </div>
	</div>
</div>
</div>



