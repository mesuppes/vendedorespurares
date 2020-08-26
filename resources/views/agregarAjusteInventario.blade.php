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
                                     <div class="table-responsive">
                                        <table class="table" id="tablaPedido">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Lote</th>
                                                    <th>Stock kilos</th>
                                                    <th>Stock unidades</th>
                                                    <th>Nuevo Stock kilos</th>
                                                    <th>Nuevo Stock unidades</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($productosLote as $producto)
                                            <tr>
                                                <td>{{$producto['id_producto']}}</td>
                                                <td>
                                                    @if($producto['lote_produccion']==Null)
                                                    C {{$producto['lote_compra']}}
                                                    @else
                                                    P {{$producto['lote_produccion']}}
                                                    @endif
                                                </td>
                                                <td>{{$producto['stock_kg']}} kg.</td>
                                                <td>{{$producto['stock_unidades']}} unidades</td>
                                                <td>
                                                    <div class="input-group">
                                                                    <input type="number" name="" min=0 step=0.001 class="form-control" placeholder="Kilos actuales">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center">&nbsp; kilos.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                </td>
                                                <td>
                                                     <div class="input-group">
                                                                    <input type="number"  name="" min=0 step=1 class="form-control" placeholder="Unidades actuales">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center">&nbsp; unidades.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                </td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                     <div class="bg-white card">
                        <div class="d-inline-flex justify-content-between">
                            <div class="d-flex pr-2">
                                <button type="submit" id="botonActualizarInventario" class="btn btn-success">Actualizar Inventario
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




