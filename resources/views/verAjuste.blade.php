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
                                    <h5 class="card-title">Ajuste Inventario</h5>
                                </div>
                                <div class="card-body">
                                  <label>Motivo:</label>
                                      <textarea rows="5" name="motivo" class="form-control border-input" placeholder="Describa el motivo de ajuste" readonly>
                                        {{$ajuste->motivo ?? "Sin descripción"}}
                                      </textarea>
                                     <div class="table-responsive">
                                        <table class="table" id="tablaPedido">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Lote</th>
                                                    <th>Ajuste en unidades</th>
                                                    <th>Ajuste en kilos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ajuste->productos as $producto)
                                            <tr>
                                                <td>
                                                  {{$producto->producto->nombre_comercial}}
 											    </td>
                                                <td>
                                                    @if(isset($producto->lote_produccion))
                                                        P-{{$producto->lote_produccion}}
                                                    @else
                                                        C-{{$producto->lote_compra}}
                                                    @endif
                                                </td>
                                                <td >
                                                    {{$producto->unidades ?? 0}} unidades
                                                </td>
                                                <td>
                                                    {{$producto->peso_kg ?? 0}} Kg
                                                </td>
                                                <td>

                                                </td>
                                                <td></td>
                                                <td>

                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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




