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
                        <form method="POST" id="formCargaPrecios" action="{{route('precios.cargaMasiva')}}">
                            @csrf
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
                                        <th>{{$producto->nombre_comercial ?? 'No hay datos'}}
                                        <input type="hidden"  class="input_idproducto"  name="idProducto[]" value="{{$producto->id_producto}}">
                                        </th>
                                        <th>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="precioKg[]" min=0 step=0.01 class="form-control precioKilo" placeholder="Precio" value="{{$producto->precio_unidad}}" disabled>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="precioUnidad[]" min=0 step=0.01 class="form-control precioUnidad" placeholder="Precio" value="{{$producto->precio_kg}}" disabled>
                                            </div>
                                        </td>
                                        <th>
                                        <input class="form-control fechaValidez" name="fechaDesde[]" type="date" value="{{$producto->fecha_desde}}" disabled>
                                        </th>
                                        <td>
                                            <div class="mb-1 divEditar">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonEditar">Editar</a>
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
                                        <th>{{$producto->producto->nombre_comercial ?? 'No hay datos'}}
                                        <input type="hidden" class="input_idproducto" name="idProducto[]" value="{{$producto->id_producto}}">
                                        </th>
                                        <th>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="precioKg[]" min=0 step=0.01 class="form-control precioKilo" placeholder="Precio" value="{{$producto->precio_unidad}}" disabled>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                            <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="precioUnidad[]" min=0 step=0.01 class="form-control precioUnidad" placeholder="Precio" value="{{$producto->precio_kg}}" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="form-control fechaValidez" name="fechaDesde[]" type="date" value="{{$producto->fecha_desde}}" disabled>
                                        </td>
                                        <td>
                                            <div class="mb-1 divEditar">
                                                <a type="button" class="btn btn-sm col-12 btn-primary botonEditar">Editar</a>
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

    <script type="text/javascript">

        $("#botonCargaMasiva").click(function(){

            $('.precioKilo').removeAttr('disabled')
            $('.spanPesos').removeAttr('disabled')
            $('.precioUnidad').removeAttr('disabled')
            $('.fechaValidez').removeAttr('disabled')
            $('#botonesCarga').append('<button type="submit" class="btn btn-sm btn-success">Cargar todo</button><a id="botonCancelarCarga" class="btn btn-sm btn-danger" onclick="window.location.reload();">Cancelar</a>')
            $('#botonCargaMasiva').remove()
            $('.botonEditar').attr('disabled','true')
            $('.botonPrecioFuturo').attr('disabled','true')
        })

        $(".botonEditar").click(function(){

            $(this).closest('tr').find('.precioKilo').removeAttr('disabled')
            $(this).closest('tr').find('.spanPesos').removeAttr('disabled')
            $(this).closest('tr').find('.precioUnidad').removeAttr('disabled')
            $(this).closest('tr').find('.fechaValidez').removeAttr('disabled')
            $(this).parent().append('<button type="submit" class="btn btn-sm btn-success">Guardar</button><a class="btn btn-sm btn-danger" onclick="window.location.reload();">Cancelar</a>')
            $('.botonEditar').attr('disabled','true')
            $('.botonPrecioFuturo').attr('disabled','true')
            $('.input_idproducto').attr('disabled','true')
            $(this).closest('tr').find('.input_idproducto').removeAttr('disabled')
            $('#botonCargaMasiva').attr('disabled','true')
            $(this).closest('tr').find('.botonEditar').remove()
            $('#formCargaPrecios').attr('action','{{route('precios.cargaProdIndividual')}}')
        })

    </script>

</div>
</div>



