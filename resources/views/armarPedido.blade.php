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
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Datos del pedido</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formArmarPedido" action="{{route('armarPedido.store')}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled placeholder="Vendedor" value="{{$pedidoDesc->vendedor['nombre']}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la condición del pago" value="{{$pedidoDesc->condicion_pago}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la forma de entrega" value="{{$pedidoDesc->forma_entrega}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese los datos del flete" value="{{$pedidoDesc->datos_flete}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
</div>
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
                                                    <th>Unidades a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Kg a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Descuento</th>
                                                    <th>MONTO TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($productosTabla as $productoPedido)
                                                <tr>
                                                    <td>{{$productoPedido->nombre_comercial}}</td>
                                                    <td>{{$productoPedido->precio_unitario_pedido}} / {{$productoPedido->medida_pedido}}</td>
                                                    <td>{{$productoPedido->cantidad_pedida}} {{$productoPedido->medida_pedido}}</td>
                                                    <td>
                                                        <div>
                                                            <input type="number"  name="" min=0 step=1 class="form-control" placeholder="Uds. a entregar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; uds.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$productoPedido->stock_unidades}} Unidades</td>
                                                    <td>
                                                        <div>
                                                            <input type="number"  name="" min=0 step=0.001 class="form-control" placeholder="Kg. a entregar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; kg.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$productoPedido->stock_kg}} Kilos</td>
                                                    <td>{{$productoPedido->descuento_pedido}}</td>
                                                    <td>$ {{$productoPedido->cantidad_pedida*$productoPedido->precio_unitario_pedido}}</td>
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
  <div class="bg-white card col-12">
                    <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: $ <a class=""></a></p>
                        </div>
                        <div class="d-flex pr-2">
                            <button type="submit" id="" class="btn btn-success">Armar pedido
</button>
                        </div>
                    </form>
                             </div>
                    </div>
</div>
                            </div>

    <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</div>
</div>




