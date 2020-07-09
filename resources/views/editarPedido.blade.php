@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white card card-user">
                    <div class="card-header">
                        @isset($vendedor)
                            <h5 class="card-title">Editar pedido de {{$vendedor}}</h5>
                        @endisset
                        @empty($vendedor)
                            <h5 class="card-title">Editar pedido</h5>
                        @endempty
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
							@csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Condición del pago</label>
                                        <input type="text" class="form-control"  name="condicionPago"  placeholder="Ingrese la condición del pago" value="{{$pedidoDescUltimo->condicion_pago}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Forma de entrega</label>
                                        <input type="text" class="form-control"  name="formaEntrega"  value="{{$pedidoDescUltimo->forma_entrega}}" placeholder="Ingrese la forma de entrega">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Datos del flete</label>
                                        <input type="text" name="datosFlete"  class="form-control" value="{{$pedidoDescUltimo->datos_flete}}" placeholder="Ingrese los datos del flete">
                                    </div>
                                </div>
                            </div>
                <div class="bg-white card">
                    <div class="card-header">
                        <h5 class>Productos</h5>
                    </div>
                </div>
                @foreach($pedidoProdUltimo as $productopedido)
                <div class="card d-inline-flex flex-row flex-wrap pl-2l-6 pl-3 pr-1">
                    <div class="card-footer col-12">
</div>
                    <div class="align-self-center col-4 col-xl-4 mb-0 mr-0 pl-0 pr-2">
                        <img src="http://pinegrow.com/placeholders/img18.jpg" alt="Card image cap">
                    </div>
                    <div class="card-block col-8 pl-0 pr-1">
                        <h6 class="card-title mb-3">{{$productopedido->producto['nombre_comercial']}}</h6>
                        <input type="hidden" name="idProducto[]" value="">
							<div class="btn-group btn-group-toggle btn-group-sm d-inline input-group pl-0 pr-0" data-toggle="buttons">
							  <label class="btn btn-secondary">
							    <input type="hidden" class="radio_kilos" name="tipoMedida[]" value="kg" checked> Kilos
							  </label>
							 <label class="btn btn-primary active">
							    <input type="radio" class="radio_unidades" name="tipoMedida[]" value="Unidades"> Unidades
							  </label>
							</div>
                        <div class="mb-2 mr-0 pr-1 text-danger text-right d-inline">$/ Unidad</div>
                        <span class="badge badge-danger badge-pill pl-1 pr-1">35 %</span>
                        <div class="mt-2 pl-0 pr-1">
                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                <input type="number"  name="cantidad[]" class="form-control" placeholder="Cantidad" value="{{$productopedido->cantidad}}">
                                <div class="input-group-append pr-0">
                                    <span class="input-group-text text-center" id="basic-addon2">&nbsp; uds.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-12">
                        <p class="mb-2 mr-0 pr-10 text-center">TOTAL: $ 5000                   </p>
                    </div>
                </div>
                @endforeach
                    @foreach($productos as $producto)
                <div class="card d-inline-flex flex-row flex-wrap pl-2l-6 pl-3 pr-1">
                    <div class="card-footer col-12">
</div>
                    <div class="align-self-center col-4 col-xl-4 mb-0 mr-0 pl-0 pr-2">
                        <img src="http://pinegrow.com/placeholders/img18.jpg" alt="Card image cap">
                    </div>
                    <div class="card-block col-8 pl-0 pr-1">
                        <h6 class="card-title mb-3">{{$producto->nombre_comercial}}</h6>
                        <input type="hidden" name="idProducto[]" value="">
                            <div class="btn-group btn-group-toggle btn-group-sm d-inline input-group pl-0 pr-0" data-toggle="buttons">
                              <label class="btn btn-secondary">
                                <input type="hidden" class="radio_kilos" name="tipoMedida[]" value="kg" checked> Kilos
                              </label>
                             <label class="btn btn-primary active">
                                <input type="radio" class="radio_unidades" name="tipoMedida[]" value="Unidades"> Unidades
                              </label>
                            </div>
                        <div class="mb-2 mr-0 pr-1 text-danger text-right d-inline">$/ Unidad</div>
                        <span class="badge badge-danger badge-pill pl-1 pr-1">35 %</span>
                        <div class="mt-2 pl-0 pr-1">
                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                <input type="number"  name="cantidad[]" class="form-control" placeholder="Cantidad">
                                <div class="input-group-append pr-0">
                                    <span class="input-group-text text-center" id="basic-addon2">&nbsp; uds.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-12">
                        <p class="mb-2 mr-0 pr-10 text-center">TOTAL: $ 5000                   </p>
                    </div>
                </div>
                @endforeach
                <div class="bg-white card">
                    <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: $ 5000                   </p>
                        </div>
                        <div class="d-flex pr-2">
                            <button type="submit" class="btn btn-success">Actualizar pedido
</button>
                        </div>
                         </form>
                    </div>
                </div>
            </div>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


        <!-- include dashboard -->
        @include('errors.custom-message')

        @yield('index')

        <!-- @include('layouts.partials.dashboard')   -->
        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
<script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>

<script type="text/javascript">


</script>



@endsection
