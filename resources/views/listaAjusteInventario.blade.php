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
                        <h5 class="card-title">Lista de ajustes inventario</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dt-mant-table">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                        <th>Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($listaAjusteInventario as $ajuste)
                                    <tr>
                                        <td>{{$ajuste['id']}}</td>
                                        <td>{{$ajuste['fecha_reg']}}</td>
                                        <td>{{$ajuste['motivo']}}</td>
                                        <td> <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="{{route('ajustes.show', $ajuste['id'])}}"> Ver ajuste</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
									No existen ajustes
									@endforelse
                                </tbody>
                                <tfoot>
</tfoot>
                            </table>
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


