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
                                    <h5 class="card-title">Editat vendedor</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formEditarVendedor" action="{{route('vendedor.update')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input type="text" name="apellido" class="form-control" placeholder="Ingrese el apellido">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 1</label>
                                                    <input type="tel" name="telefono1" class="form-control" placeholder="Ingrese un telefono">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefono 2</label>
                                                    <input type="tel" name="telfono2" class="form-control" placeholder="Ingrese otro telefono">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="mail" name="email" class="form-control" placeholder="Ingrese un mail">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CUIT</label>
                                                    <input type="text" name="cuit" class="form-control" placeholder="Ingrese el CUIT">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <input type="text" name="direccion" class="form-control" placeholder="Ingrese la direccion">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ciudad</label>
                                                    <input type="text" name="ciudad" class="form-control" placeholder="Ingrese la ciudad">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input type="text" name="provincia" class="form-control" placeholder="Ingrese la provincia">
                                                </div>
                                            </div>
                                            </div>
                                </div>
                     <div class="bg-white card">
                        <div class="d-inline-flex justify-content-between">
                            <div class="d-flex pr-2">
                                <button type="submit" id="botonAgregarVendedor" class="btn btn-success">Agregar Vendedor
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




