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
                                    <h5 class="card-title">Cliente {{$cliente->nombre}} {{$cliente->apellidos}}</h5>
                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" readonly placeholder="Ingrese el nombre" value="{{$cliente->nombre}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input type="text" name="apellido" class="form-control" placeholder="Ingrese el apellido" value="{{$cliente->apellidos}}" readonly>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 1</label>
                                                    <input type="tel" name="telefono1" class="form-control" placeholder="Ingrese un telefono" value="{{$cliente->telefono1}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 2</label>
                                                    <input type="tel" name="telfono2" class="form-control" placeholder="Ingrese otro telefono" value="{{$cliente->telefono2}}" readonly>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="mail" name="email" class="form-control" placeholder="Ingrese un mail" value="{{$cliente->email}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CUIT</label>
                                                    <input type="text" name="cuit" class="form-control" placeholder="Ingrese el CUIT" value="{{$cliente->cuit}}" readonly>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <input type="text" name="direccion" class="form-control" placeholder="Ingrese la direccion" value="{{$cliente->direccion}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ciudad</label>
                                                    <input type="text" name="ciudad" class="form-control" placeholder="Ingrese la ciudad" value="{{$cliente->ciudad}}" readonly>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input type="text" name="provincia" class="form-control" placeholder="Ingrese la provincia" value="{{$cliente->provincia}}" readonly>
                                                </div>
                                            </div>
                                            </div>
                                </div>
                     <div class="bg-white card">
                            <div class="form-group">
                                        <label>Descuento general</label>
                                          <a href="{{route('vendedor.createDescuento',$cliente->id_vendedor)}}" class="btn btn-warning btn-sm">Editar</a>
                                        <div class="input-group">
                                            <input type="number" min="0" step=0.1 class="form-control" name="descuentoGeneral" placeholder="Ingrese porcentaje de descuento general" readonly value="{{$cliente->descuentoGeneral->descuento}}">
                                        <div class="input-group-append pr-0">
                                            <span class="input-group-text text-center">&nbsp;%</span>
                                        </div>
                                        </div>
                                    </div>
                        </div>
                        <div class="bg-white card">
                             <div class="row">
                                <table id="tablaDescuentosProductos">
                                    <thead>
                                        <tr>
                                           <th>Producto</th>
                                           <th>Descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cliente->descuentoProductos()->get() as $producto)
                                        <tr>
                                            <td>
                                                {{$producto->producto->nombre_comercial}}
                                            </td>
                                            <td>
                                                {{$producto->descuento}} %
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bg-white card">
                            <div class="form-group">
                                  <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                        <label>Credito</label>
                                <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control " placeholder="Credito" value="{{$cliente->credito()->orderby('fecha_reg','desc')->first()->monto}}" readonly>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha desde</label>
                                  <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                                <input type="text"  name="" class="form-control " placeholder="fecha desde" value="{{$cliente->credito()->orderby('fecha_reg','desc')->first()->fecha_reg->formatLocalized('%d/%m/%Y')}}" readonly>
                                            </div>
                                    </div>
                                         <a href="{{route('vendedor.createCredito',$cliente->id_vendedor)}}" class="btn btn-warning btn-sm">Editar</a>
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




