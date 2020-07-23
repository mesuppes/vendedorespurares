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
                                    <h5 class="card-title">FACTURA PROFORMA</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formInspeccionarFactura">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>N° Factura Proforma</label>
                                                    <input type="text" class="form-control" disabled value={{$factura->id}}>
                                                </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled  value="{{$factura->id_cliente}}">
                                                </div>
                                            </div>
                                        
                                        <br>DATOS DEL PEDIDO<br>

                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled  value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" disabled  value="1">
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
                                                    <th>Lote</th>
                                                    <th>Unidades</th>
                                                    <th>Kg</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Descuento</th>
                                                    <th>Monto Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($factura->productos as $productoFactura)
                                                <tr>
                                                    <!--PRODUCTO-->
                                                    <td>
                                                        {{$productoFactura->producto->nombre_comercial}}
                                                    </td>
                                                    <!--LOTE-->
                                                    <td>
                                                        @if(isset($productoFactura->lote_produccion))
                                                            <b>P-</b>{{$productoFactura->lote_produccion}}
                                                        @elseif(isset($productoFactura->lote_compra))
                                                            <b>C-</b>{{$productoFactura->lote_compra}}
                                                        @endif
                                                    </td>
                                                    <!--UNIDADES-->
                                                    <td>
                                                        {{round($productoFactura->cantidad_unidades,0)}}
                                                    </td>
                                                    <!--KG-->
                                                    <td>
                                                        {{$productoFactura->cantidad_kg}}
                                                    </td>
                                                    <!--PRECIO UNITARIO-->
                                                    <td>
                                                        $ {{$productoFactura->precio_unitario}}
                                                    </td>
                                                    <!--DESCUENTO-->
                                                    <td>
                                                        $ {{$productoFactura->descuento}}
                                                    </td>
                                                    <!--MONTO TOTAL-->
                                                    <td>
                                                        $ {{$productoFactura->precio_total}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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




