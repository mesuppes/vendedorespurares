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
                        <h5 class="card-title">Lista de pedidos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table"  id="tablalistapedidos">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Vendedor</th>
                                        <th>Estado</th>
                                        <th>Monto</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($listaPedidos as $pedido)
                                    <tr>
                                        <th>{{$pedido->fecha_reg->formatLocalized('%d/%m/%Y - %H:%M')}}</th>
                                        <th>{{$pedido->vendedor['nombre']}}</th>
                                        <td><h5><span class="badge
                                                @if(isset($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre) and ($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre=='Pendiente de aprobación'or'Modificado'))
                                                badge-warning
                                                @elseif(isset($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre) and ($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre=='Aprobado'))
                                                badge-success
                                                @elseif(isset($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre) and ($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre=='Abortado'or'Rechazado'))
                                                badge-danger
                                                @elseif(isset($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre) and ($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre=='Aprobado automática'))
                                                badge-secondary
                                                @elseif(!isset($pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre))
                                                badge-danger
                                                @endif
                                                ">{{$pedido->workflow()->orderBy('id_workflow','desc')->first()->statusN->nombre ?? "error"}}
                                            </span></h5></td>
                                        <th>${{$pedido->productos->sum('precio_final')}}</th>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="{{route('pedido.show', $pedido->id_pedido)}}"> Ver pedido</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
									No existen pedidos
									@endforelse
                                </tbody>
                            </table>
                             {{$listaPedidos->links()}}
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

<script src="{{asset('dashboard/assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/plugins/responsive.bootstrap.min.js')}}"></script>
<script>


var tablaPedidos=$('#tablalistapedidos').DataTable({
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
            "lengthMenu": "Mostrar _MENU_ pedidos por pagina",
            "zeroRecords": "Ningún pedido cumple el criterio de búsqueda",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay pedidos en la base de datos",
            "infoFiltered": "(filtrado de _MAX_ pedidos en total)",
            "search": "_INPUT_",
            "searchPlaceholder": "Buscar"},
        "order": [[0, 'desc']],

        })

</script>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection


