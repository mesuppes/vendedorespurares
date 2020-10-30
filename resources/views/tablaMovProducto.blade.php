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
                            <table class="table display nowrap" style="width:100%" id="movimientos">
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
                        </div>
                    </div>

            <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>

<script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/paper-dashboard.min.js')}}"></script>

<script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
 <script src="{{asset('dashboard/assets/js/plugins/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('dashboard/assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/jszip.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/buttons.html5.min.js')}}"></script>
 <link href="{{asset('dashboard/assets/js/plugins/buttons.dataTables.min.css')}}" rel="stylesheet" />
    <script>
$('#movimientos').DataTable({
    "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": {
            details: true
        },
        "aaSorting": [
        [0, "desc"]
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ movimientos por pagina",
            "zeroRecords": "Ningún movimiento cumple el criterio de búsqueda",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay movimientos en la base de datos",
            "infoFiltered": "(filtrado de _MAX_ movimientos en total)",
            "search": "_INPUT_",
            "searchPlaceholder": "Buscar"},
        "order": [[0, 'desc']],
 dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    } )

    </script>
                    </div>

                </div>
            </div>
        </div>
    </div>

                </div>
	        </div>
	    </div>
	</div>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection


