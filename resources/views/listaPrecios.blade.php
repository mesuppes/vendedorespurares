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
                    <div class="card-header d-flex">
                        <h5 class="card-title">Lista de precios</h5>
                        <div id="botonesCarga" class="ml-auto">
                        <a id="botonCargaMasiva" class="btn btn-sm btn-info">Editar todo</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Productos sin precio</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio por unidad</th>
                                        <th>Precio por kilo</th>
                                        <th>Valido desde</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosSinPrecio as $producto)
                                    <tr>
                                        <th>{{$producto->nombre_comercial ?? 'No hay datos'}}</th>
                                        <th>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" readonly>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control precioKilo" placeholder="Precio" value="{{$producto->precio_kg}}" readonly>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" readonly>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control precioUnidad" placeholder="Precio" value="{{$producto->precio_unidad}}" readonly>
                                            </div>
                                        </td>
                                        <th>
                                        <input class="form-control fechaValidez" type="date" value="{{$producto->fecha_desde}}" readonly>
                                        </th>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonEditar"
                                                   href="">Editar</a>
                                            </div>
                                        </td>
                                         <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonPrecioFuturo"
                                                   href="">Ver Precio futuro</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                     <div class="card-body">
                        <h3>Productos</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio por unidad</th>
                                        <th>Precio por kilo</th>
                                        <th>Valido desde</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listaPrecios as $producto)
                                    <tr>
                                        <th>{{$producto->producto->nombre_comercial ?? 'No hay datos'}}</th>
                                        <th>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" readonly>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control precioKilo"  placeholder="Precio" value="{{$producto->precio_kg}}" readonly>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" readonly>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control precioUnidad" placeholder="Precio" value="{{$producto->precio_unidad}}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="form-control fechaValidez" type="date" value="{{$producto->fecha_desde}}" readonly>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonEditar"
                                                   href="">Editar</a>
                                            </div>
                                        </td>
                                         <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonPrecioFuturo"
                                                   href="">Ver Precio futuro</a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
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

        $("#botonCargaMasiva").click(function(){

            $('.precioKilo').removeAttr('readonly')
            $('.spanPesos').removeAttr('readonly')
            $('.precioUnidad').removeAttr('readonly')
            $('.fechaValidez').removeAttr('readonly')
            $('#botonesCarga').append('<a id="botonCancelarCarga" class="btn btn-sm btn-danger">Cancelar</a>')
            $('#botonCargaMasiva').removeClass('btn-info').addClass('btn-success')
            $('#botonCargaMasiva').html('Cargar todo')
            $('.botonEditar').attr('disabled','true')
            $('.botonPrecioFuturo').attr('disabled','true')
        })

    </script>

</div>
</div>



