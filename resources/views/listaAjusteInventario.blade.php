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
                                        <th>Ajustes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($listaAjusteInventario as $ajuste)
                                    <tr>
                                        <td>{{$ajuste}}</td>
                                        <td>

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


