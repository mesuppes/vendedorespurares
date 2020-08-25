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
                                    <h5 class="card-title">Agregar ajuste</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formAgregarAjuste" action="{{route('ajustes.store')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                  @foreach($productosLote as $producto)
                                                          {{$producto}}

                                                        @endforeach
                                                <div class="form-group">
                                                    <label>Nombre del producto</label>
                                                    <input type="text" name="nombreComercial" class="form-control" placeholder="Ingrese el nombre del producto" value="{{old('nombreComercial')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peso Unitario</label>
                                                    <input type="number" name="pesoUnitario" min=0 class="form-control" placeholder="Ingrese el peso unitario" value="{{old('pesoUnitario')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Descripcion</label>
                                                <textarea rows="5" name="descripcion" class="form-control border-input" placeholder="Describa el producto" value="{{old('descripcion')}}"></textarea>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="selectVendedor">Producto de fabrica</label>
                                            <select class="selectpicker form-control" data-style="btn btn-danger btn-block" name="idProductoProduccion">
                                             <option value= "" selected>Seleccione producto</option>
                                             <option value= "">Ninguno</option>

                                            </select>
                                            </div>
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

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




