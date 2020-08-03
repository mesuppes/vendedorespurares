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
                                    <h5 class="card-title">Agregar Compra</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{route('compras.store')}}">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Proveedor</label>
                                                    <input type="text" name="idProveedor" class="form-control"  placeholder="Proveedor">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>N° Remito</label>
                                                    <input type="text" class="form-control" name="nroRemito" placeholder="n° remito" value="{{old('nroRemito')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>N° Lote de compra</label>
                                                    <input type="text" class="form-control" name="loteCompra" value=" {{$loteCompra}} " readonly placeholder="lote de compra" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Fecha de compra</label>
                                                    <input type="date" class="form-control" name="fechaCompra"  placeholder="fecha" value="{{old('fechaCompra')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentario</label>
                                                    <textarea class="form-control" name="comentarios"  placeholder="Ingrese algún comentario" value="{{old('comentarios')}}"></textarea>
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
                                    <h5 class="card-title">Productos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad Unidades</th>
                                                    <th>Cantidad kg</th>
                                                    <th>Monto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 @foreach($productos as $producto)
                                                <tr>
                                                    <td>{{$producto->nombre_comercial}}
                                                           <input type="hidden"  name="idProducto[]"  class="form-control" value="{{$producto->id_producto}}">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number"  name="unidades[]" min=0 step=1 class="form-control" placeholder="Uds. a comprar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; uds.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div  class="input-group">
                                                            <input type="number"  name="peso_kg[]" min=0 step=0.001 class="form-control" placeholder="Kg. a comprar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; kg.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>$ <a class="monto_producto"></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
</div>
  <div class="bg-white card">
                <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: $ <a class="monto_total"></a></p>
                        </div>
                        <div class="d-flex pr-2">
                            <button type="submit" id="botonHacerPedido" class="btn btn-success">Hacer compra
</button>
                        </div>
                             </div>
                    </div>
                         </form>
</div>
                            </div>

    <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection





