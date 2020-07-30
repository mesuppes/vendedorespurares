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
                                @if(session('respuesta'))
                                <div class="alert alert-success">
                                {{session('respuesta')}}
                                 </div>
                                @endif
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Cliente {{$cliente->nombre}} {{$cliente->apellidos}}</h5>
                                <a href="{{route('vendedor.edit',$cliente->id_vendedor)}}" class="btn btn-warning btn-sm ml-auto">Editar datos</a>
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
                                </div>
                         <div class="bg-white card card-user">
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Descuentos</h5>
                                <a href="{{route('vendedor.createDescuento',$cliente->id_vendedor)}}" class="btn btn-warning btn-sm ml-auto">Editar descuentos</a>
                                </div>
                                <div class="card-body">
                                        <div class="form-group col-3">
                                            <label for="descuentoGeneral">Descuento general</label>
                                              <div class="input-group">
                                            <input type="number" min="0" step=0.1 class="input-group-text form-control" name="descuentoGeneral" placeholder="Ingrese porcentaje de descuento general" readonly value="{{$cliente->descuentoGeneral->descuento*100 ?? 'No hay datos'}}">
                                        <div class="input-group-append">
                                            <span class="form-control text-center" disabled>&nbsp;%</span>
                                        </div>
                                         </div>
                                        </div>
                                        <br>
                             <div class="row col-6">
                                <div class="table-responsive">
                                <table id="tablaDescuentosProductos" class="table">
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
                                                {{$producto->descuento*100}} %
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        </div>
                            <div class="bg-white card card-user">
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Crédito</h5>
                                <a href="{{route('vendedor.createCredito',$cliente->id_vendedor)}}" class="btn btn-warning btn-sm ml-auto">Editar crédito</a>
                                </div>
                                <div class="card-body">
                                        <div class="form-group col-3">
                                            <label for="descuentoGeneral">Crédito</label>
                                              <div class="input-group">
                                             <div class="input-group-prepend disabled pr-0">
                                                    <span class="input-group-text form-control text-center spanPesos" disabled>$ </span>
                                            </div>
                                                <input type="number"  name="" min=0 step=0.01 class="form-control " placeholder="Credito" value="{{$cliente->credito()->orderby('fecha_reg','desc')->first()->monto ?? 'No hay datos'}}" readonly>
                                            </div>
                                         </div>
                                          <div class="form-group col-3">
                                            <label for="descuentoGeneral">Fecha desde</label>
                                              <div class="input-group">
                                                 <input type="text"  name="" class="form-control " placeholder="fecha desde" value="{{$cliente->credito()->orderby('fecha_reg','desc')->first()->fecha_reg ?? 'No hay datos'}}" readonly>
                                            </div>
                                         </div>
                                        </div>
                        </div>

                        <!-- USUARIO -->

                        <div class="bg-white card card-user">
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Usuario del Sistema</h5>

                                @if(isset($cliente->usuario))
                                </div>
                                     <div class="card-body">
                            <div class="col-md-6"   >
                                <label for="descuentoGeneral">Mail del Usuario</label>
                                  <div class="input-group">
                                 <div class="input-group-prepend disabled pr-0">
                                </div>
                                    <input type="mail" name="" class="form-control" placeholder="email" value="{{$cliente->usuario->email ?? 'No hay datos'}}" readonly>
                                </div>
                             </div>
                              <div class="col-md-6">
                                <label for="descuentoGeneral">Fecha alta</label>
                                  <div class="input-group">
                                     <input type="text"  name="" class="form-control " placeholder="fecha alta" value="{{$cliente->usuario->created_at->formatLocalized('%d/%m/%Y - %H:%M') ?? 'No hay datos'}}" readonly>
                                </div>
                             </div>
                            </div>

                                @else
                                <a href="{{route('vendedor.generarUser',$cliente->id_vendedor)}}" class="btn btn-info btn-sm  ml-auto">Generar Usuario</a>
                                </div>
                                @endif


                        </div>





                        </div>
                         </form>

                    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
 <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection



    <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>



