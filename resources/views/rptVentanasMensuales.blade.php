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
                        <form method="POST" id="formReporte" action="{{route('reporte.ventas')}}">
                            @csrf
                    <div class="card-header d-flex">
                        <h5 class="card-title">Reporte</h5>
                        <div id="botonesCarga" class="ml-auto">
                              <div class="form-group">
                                                    <label>Fecha desde</label>
                                                    <input type="month" class="form-control" value="@php
                                                     $fecha_actual = date("d-m-Y");
												     //resto 1 mes
                                                     echo date("Y-m",strtotime($fecha_actual."- 5 month"));
                                                     @endphp" name="fechaDesde" id="fechaDesde">
                             </div>
                              <div class="form-group">
                                                    <label>hasta</label>
                                                    <input type="month" value="@php echo date('Y-m'); @endphp" max="@php echo date('Y-m'); @endphp" min="@php
                                                     $fecha_actual = date("d-m-Y");
												     //resto 1 mes
                                                     echo date("Y-m",strtotime($fecha_actual."- 4 month"));
                                                     @endphp" class="form-control" name="fechaHasta" id="fechaHasta">
                             </div>
                        <button id="botonCargaReporte" type="submit" class="btn btn-sm btn-info">Cargar reporte</button>
                        </div>
                    </div>
                </form>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        @if($periodos)
                                    	<th>ID</th>
                                        <th>Producto</th>
                                        @foreach($periodos as $periodo)
                                        <th>{{$periodo}}</th>
           								@endforeach
                                        @else
                                        Seleccione un período para cargar datos
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($datos)
									@foreach($datos as $dato)
                                    <tr>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                        <td>{{$dato}}</td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
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

    <script type="text/javascript">

		$("#fechaDesde" ).on('change', function() {

			var fecha= document.getElementById('fechaDesde').cloneNode(true)
			fecha.stepUp(5)
			var fecha_maxima=fecha.value
			$('#fechaHasta').attr('max',fecha_maxima)
			fecha.stepDown(4)
			var fecha_minima=fecha.value
			$('#fechaHasta').attr('min',fecha_minima)

		})

    </script>


        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




