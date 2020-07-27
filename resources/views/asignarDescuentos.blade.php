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
                        <h5 class="card-title">Asignar descuento</h5>
                    </div>

                    <div>
                        @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route('vendedor.descuentoStore')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control"  name="idVendedor"  placeholder="Vendedor" value="{{$vendedor->id_vendedor}}">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" placeholder="Vendedor" value="{{$vendedor->nombre}} {{$vendedor->apellidos}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Descuento general</label>
                                        <div class="input-group">
                                            <input type="number" min="0" step=0.1 class="form-control" name="descuentoGeneral" placeholder="Ingrese porcentaje de descuento general" value="{{$vendedor->descuentoGeneral->descuento*100 ?? ''}}">
                                        <div class="input-group-append pr-0">
                                            <span class="input-group-text text-center">&nbsp;%</span>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="table-responsive col-6">
                                <table id="tablaDescuentosProductos" class="table">
                                    <thead>
                                        <tr>
                                           <th>Producto</th>
                                           <th>Descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vendedor->descuentoProductos()->get() as $producto)
                                         <tr>
                                            <td>
                                                <div class="input-group">
                                                <select name="idProducto[]" class="selectpicker form-control">
                                                      <option value="{{$producto->id_producto}}" selected>{{$producto->producto->nombre_comercial}}
                                                            </option>
                                                        @foreach($productos as $productosincargar)
                                                            <option value="{{$productosincargar->id_producto}}">{{$productosincargar->nombre_comercial}}
                                                            </option>
                                                        @endforeach
                                                </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" min="0" step=0.1 class="form-control inputDescuento" name="descuentoProducto[]" placeholder="Ingrese porcentaje de descuento" value="{{$producto->descuento*100}}">
                                                <div class="input-group-append pr-0">
                                                    <span class="input-group-text text-center">&nbsp;%</span>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr id="trDescuentoProducto">
                                            <td>
                                                <div class="input-group">
                                                <select name="idProducto[]" class="selectpicker form-control">
                                                    <option value= "" selected>Seleccione producto</option>
                                                        @foreach($productos as $producto)
                                                            <option value="{{$producto->id_producto}}">{{$producto->nombre_comercial}}
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" min="0" step=0.1 class="form-control inputDescuento" name="descuentoProducto[]" placeholder="Ingrese porcentaje de descuento">
                                                <div class="input-group-append pr-0">
                                                    <span class="input-group-text text-center">&nbsp;%</span>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-info" id="botonAgregarDescuentoProducto">Agregar producto</button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success" type="submmit">Asignar descuento</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    </div>
                </div>
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

    $("#botonAgregarDescuentoProducto").click(function(event){

        event.preventDefault()
        $( "#trDescuentoProducto" ).clone().appendTo( "#tablaDescuentosProductos" ).find(".inputDescuento").val("").end();

    })
</script>



@endsection
