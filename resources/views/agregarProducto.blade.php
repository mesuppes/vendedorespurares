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
                                    <h5 class="card-title">Agregar producto</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formAgregarProducto" action="{{route('productos.store')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre del producto</label>
                                                    <input type="text" name="nombreComercial" class="form-control" placeholder="Ingrese el nombre del producto">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peso Unitario</label>
                                                    <input type="number" name="peso_unitario" min=0 class="form-control" placeholder="Ingrese el peso unitario">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <textarea name="descripcion" cols="30" rows="10">Ingrese una descripción</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                 <select name="idProductoProduccion">
                                                    <option value= "" selected>Seleccione producto</option>
                                                    <option value= "">Ninguno</option>
                                                        @foreach($ProductoFabrica as $producto)
                                                            <option value="{{$producto->id_producto}}">{{$producto->nombre}}
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                </div>
                     <div class="bg-white card">
                        <div class="d-inline-flex justify-content-between">
                            <div class="d-flex pr-2">
                                <button type="submit" id="botonAgregarProducto" class="btn btn-success">Agregar producto
</button>
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
</div>
</div>




