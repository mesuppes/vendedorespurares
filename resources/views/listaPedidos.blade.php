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
                            <table class="table">
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
                                        <th>{{$pedido->fecha_reg}}</th>
                                        <th>{{$pedido->vendedor['nombre']}}</th>
                                        <td><font color="#ffffff">
                                            <span style="font-size: 10.5px; white-space: nowrap; background-color: rgb(81, 203, 206);">
                                                <b>
                                                Pendiente    
                                                </b>
                                            </span></font></td>
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
                                <tfoot>
</tfoot>
                            </table>
                        </div>
                    </div>
                </div>
	        </div>
	    </div>
	</div>
</div>
</div>



