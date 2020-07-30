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
                                    <h5 class="card-title">Agregar vendedor</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formAgregarVendedor" action="{{route('vendedores.store')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" value="{{old('nombre')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input type="text" name="apellido" class="form-control" placeholder="Ingrese el apellido" value="{{old('apellido')}}">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 1</label>
                                                    <input type="tel" name="telefono1" class="form-control" placeholder="Ingrese un telefono" value="{{old('telefono1')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 2</label>
                                                    <input type="tel" name="telfono2" class="form-control" placeholder="Ingrese otro telefono" value="{{old('telfono2')}}">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="mail" name="email" class="form-control" placeholder="Ingrese un mail" value="{{old('email')}}">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CUIT/CUIL</label>
                                                    <div class="input-group">
                                                    <div class="input-group-append">
                                                          <select class="selectpicker form-control" data-style="btn btn-danger btn-block" required name="tipoDocumento">
                                                            <option selected>Seleccione</option>
                                                            <option value="CUIT">CUIT</option>
                                                            <option value="CUIL">CUIL</option>
                                                            </select>
                                                    </div>
                                                    <input type="text" name="cuit" class="form-control" placeholder="Ingrese el nro" value="{{old('cuit')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Inscripción social</label>
                                                    <div class="input-group">
                                                          <select class="selectpicker form-control" data-style="btn btn-danger btn-block" required name="inscripcionAfip">
                                                            <option selected>Seleccione</option>
                                                               <option value="M">Monotributo</option>
                                                            <option value="RI">Responsable inscripto</option>
                                                            <option value="CF">Consumidor final</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <input type="text" name="direccion" class="form-control" placeholder="Ingrese la direccion" value="{{old('direccion')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ciudad</label>
                                                    <input type="text" name="ciudad" class="form-control" placeholder="Ingrese la ciudad" value="{{old('ciudad')}}">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Codigo postal</label>
                                                    <input type="number" name="codigoPostal" class="form-control" placeholder="Ingrese el CP" value="{{old('codigoPostal')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input type="text" name="provincia" class="form-control" placeholder="Ingrese la provincia" value="{{old('provincia')}}">
                                                </div>
                                            </div>
                                            </div>
                                </div>
                     <div class="bg-white card">
                        <div class="d-inline-flex justify-content-between">
                            <div class="d-flex pr-2">
                                <button type="submit" id="botonAgregarVendedor" class="btn btn-success">Agregar Vendedor</button>
                        </div>
                         </form>
                             </div>
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
        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection



