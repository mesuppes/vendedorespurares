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

                    <div class="card-header d-flex">
                        <h5 class="card-title">Lista de precios</h5>
                        <div id="botonesCarga" class="ml-auto">
                        <a href="{{route('precios.create')}}" class="btn btn-sm btn-info">Editar</a>
                        </div>
                    </div>
                     <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="Precios">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio por unidad</th>
                                        <th>Precio por kilo</th>
                                        <th>Valido desde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listaPrecios as $producto)
                                    <tr>
                                        <th>{{$producto->producto->nombre_comercial ?? 'No hay datos'}}
                                        </th>
                                        <td>
                                            $ {{$producto->precio_unidad}} /unidad
                                        </td>
                                        <td>
                                            $ {{$producto->precio_kg}} /kilo
                                        </td>
                                        <td>
                                            {{$producto->fecha_desde}}
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	</div>

   <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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
$('#Precios').DataTable({
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
            "lengthMenu": "Mostrar _MENU_ productos por pagina",
            "zeroRecords": "Ningún producto cumple el criterio de búsqueda",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay productos en la base de datos",
            "infoFiltered": "(filtrado de _MAX_ productos en total)",
            "search": "_INPUT_",
            "searchPlaceholder": "Buscar"},
        "order": [[0, 'desc']],
 dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    } )

    </script>
        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




