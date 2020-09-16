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
                                    <h5 class="card-title">Editar producto</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formEditarProducto" action="{{route('producto.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="idProducto" value="{{$producto->id_producto}}">
                                                <div class="form-group">
                                                    <label>Nombre del producto</label>
                                                    <input type="text" name="nombreComercial" class="form-control" placeholder="Ingrese el nombre del producto" value="{{$producto->nombre_comercial}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peso Unitario</label>
                                                    <input type="number" name="pesoUnitario" min=0 class="form-control" placeholder="Ingrese el peso unitario" value="{{$producto->peso_unitario}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Descripcion</label>
                                                <textarea rows="5" name="descripcion" class="form-control border-input" placeholder="Describa el producto" value="{{$producto->descripcion}}"></textarea>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="selectVendedor">Producto de fabrica</label>
                                            <select class="selectpicker form-control" data-style="btn btn-danger btn-block" name="idProductoProduccion" required>
                                             <option value="{{$producto->productoFabrica->id_producto ?? ""}}" selected>{{$producto->productoFabrica->nombre ?? "Sin asignar"}}</option>
                                             <option value="">Ninguno</option>
                                                        @foreach($ProductoFabrica as $producto_fabrica)
                                                            <option value="{{$producto_fabrica->id_producto}}">{{$producto_fabrica->nombre}}
                                                            </option>
                                                        @endforeach
                                            </select>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <img src= "{{asset("uploads/imagenProducto/".$producto->url_foto)}}" class="d-inline" width="100" alt="Imagen del producto">
                                                <div class="form-group">
                                                     <input accept="image/*" type="file" name="imagen" placeholder="Imagen">
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>

                     <div class="bg-white card">
                        <div class="d-inline-flex justify-content-between">
                            <div class="d-flex pr-2">
                                <button type="submit" id="botonAgregarProducto" class="btn btn-success">Editar producto
</button>
                        </div>
                             </div>
                         </form>
                    </div>
                    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
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




