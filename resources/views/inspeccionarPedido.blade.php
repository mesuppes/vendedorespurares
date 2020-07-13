@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

         <div class="content">
                    <div class="row">
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
              @if(session('pedidoAgregado'))
                    <div class="alert alert-success" role="alert">
                      El pedido se creo bien
                    </div>
                @endif
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Datos del pedido
                                    @foreach ($wf as $workflow)
                                    @if($workflow->status_n)
                                    <span class="badge badge-warning">{{$workflow->status_n}}</span>
                                    @endif
                                    </h5>
                                    <a href="{{route('pedido.edit', $pedidoDescUltimo->id_pedido)}}" class="btn btn-sm btn-primary ml-auto">Editar pedido</a>
                                    <a href="{{route('pedido.aprobar', $workflow->id_workflow)}}"  class="btn btn-sm btn-success ml-auto">Aprobar pedido</a>
                                    <a class="btn btn-sm btn-danger ml-auto">Rechazar pedido</a>
                                    @endforeach
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled placeholder="Vendedor" value="{{$pedidoDescUltimo->vendedor['nombre']}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la condición del pago" value="{{$pedidoDescUltimo->condicion_pago}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la forma de entrega" value="{{$pedidoDescUltimo->forma_entrega}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese los datos del flete" value="{{$pedidoDescUltimo->datos_flete}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
                                <div class="card-header">
                                    <h5 class="card-title">Productos pedidos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad pedida</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pedidoProdUltimo as $producto)
                                                <tr>
                                                    <td>{{$producto->producto['nombre_comercial']}}</td>
                                                    <td>${{$producto->precio_unitario}}/{{$producto->tipo_medida}}</td>
                                                    <td>
                                                        <div class="mb-1">
                                                            {{$producto->cantidad}} {{$producto->tipo_medida}}
                                                        </div>
                                                    </td>
                                                    <td>${{$producto->precio_final}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>X productos</th>
                                                    <th colspan="2">TOTAL $ </th>
                                                </tr>
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



