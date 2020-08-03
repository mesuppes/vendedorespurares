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
                                    <h5 class="card-title">Datos del producto</h5>
                                    <a href="{{route('pedido.edit', $producto->id_producto)}}" class="btn btn-sm btn-primary ml-auto" disabled>Editar producto</a>
                                </div>
                                <div class="card-body">
                                    <div class="col-4 d-inline">
                                        <img src= "{{$producto->url_foto}}" class="d-inline" width="100" alt="Imagen del producto">
                                    </div>
                                    <div class="col-8 d-inline">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Producto</label>
                                                    <input type="text" class="form-control" readonly placeholder="Ingrese el nombre del producto" value="{{$producto->nombre_comercial}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peso Unitario</label>
                                                    <input type="number" class="form-control" readonly placeholder="Ingrese el peso unitario" value="{{$producto->peso_unitario}}">
                                                </div>
                                            </div>
                                              </div>
                                              <div class="row">
                                                      <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="selectVendedor">Producto de fabrica</label>
                                            <select class="selectpicker form-control" data-style="btn btn-danger btn-block" disabled name="idProductoProduccion">
                                             <option selected>{{$producto->productoFabrica->nombre}}</option>
                                            </select>
                                            </div>
                                            </div>
                                              </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Descripción</label>
                                                    <textarea class="form-control" readonly>{{$producto->descripcion}}</textarea>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                         </div>
                                    </form>
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

    <script type="text/javascript">


</script>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




