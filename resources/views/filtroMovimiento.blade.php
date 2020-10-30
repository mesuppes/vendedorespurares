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
                        <form method="POST"  action="{{route('productos.movimiento')}}">
                            @csrf
                    <div class="card-header d-flex">
                        <h5 class="card-title">Movimientos</h5>
                    </div>
                        <div class="card-body">
                          <div class="row">
                              <div class="col-6">
                              <div class="form-group">
                                                    <label>Fecha desde</label>
                                                    <input type="date" class="form-control" value="@php
                                                     $fecha_actual = date("d-m-Y");
												     //resto 1 mes
                                                     echo date("Y-m",strtotime($fecha_actual."- 5 month"));
                                                     @endphp" name="fecha_desde" id="fechaDesde">
                             </div>
                              <div class="form-group">
                                                    <label>hasta</label>
                                                    <input type="date" value="@php echo date('Y-m'); @endphp" max="@php echo date('Y-m'); @endphp" min="@php
                                                     $fecha_actual = date("d-m-Y");
												     //resto 1 mes
                                                     echo date("Y-m",strtotime($fecha_actual."- 4 month"));
                                                     @endphp" class="form-control" name="fecha_hasta" id="fechaHasta">
                             </div>
                         </div>
                         </div>
                         </div>
                     </div>
                          <div class="bg-white card card-user">

                        <button id="botonCarga" type="submit" class="btn  ml-auto btn-info">Cargar movimientos</button>

                    </div>
                </div>
            </div>
	    </div>
	</div>

   <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script type="text/javascript" src="{{asset('dashboard/assets/js/plugins/jspdf.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('dashboard/assets/js/plugins/jspdf.plugin.autotable')}}"></script>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




