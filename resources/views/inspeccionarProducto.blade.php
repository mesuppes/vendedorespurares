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
                                    <form>
                                        <img src= "{{$producto->url_foto}}" width="100" alt="Card image cap">
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <textarea name="" id="" cols="30" rows="10" readonly>{{$producto->descripcion}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
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
</div>
</div>




