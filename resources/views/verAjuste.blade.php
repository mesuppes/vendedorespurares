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
                                      <textarea rows="5" name="motivo" class="form-control border-input" placeholder="Describa el motivo de ajuste" readonly></textarea>
                                            </div>
                                     <div class="table-responsive">
                                        <table class="table" id="tablaPedido">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Lote</th>
                                                    <th>Stock kilos</th>
                                                    <th>Nuevo Stock kilos</th>
                                                    <th>Ajuste</th>
                                                    <th>Stock unidades</th>
                                                    <th>Nuevo Stock unidades</th>
                                                    <th>Ajuste</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                  {{$ajuste}}
 											</td>
                                                <td>

                                                </td>
                                                <td ></td>

                                                <td>

                                                </td>
                                                <td>

                                                </td>
                                                <td></td>
                                                <td>

                                                </td>
                                                <td>

                                                </td>
                                            </tr>

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




