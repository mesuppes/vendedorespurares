@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white card card-user">
                    <div class="card-header">
                        @isset($vendedor)
                            <h5 class="card-title">Datos del pedido para {{$vendedor}}</h5>
                        @endisset
                        @empty($vendedor)
                            <h5 class="card-title">Datos del pedido</h5>
                        @endempty
                    </div>
                    <div class="card-body">
                        <form method="POST" id="formHacerPedido" action="{{route('pedido.store')}}">
							@csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Condición del pago</label>
                                        <input type="text" class="form-control"  name="condicionPago"  placeholder="Ingrese la condición del pago">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Forma de entrega</label>
                                        <input type="text" class="form-control"  name="formaEntrega"  placeholder="Ingrese la forma de entrega">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Datos del flete</label>
                                        <input type="text" name="datosFlete"  class="form-control" placeholder="Ingrese los datos del flete">
                                    </div>
                                </div>
                            </div>
                <div class="bg-white card">
                    <div class="card-header">
                        <h5 class>Productos</h5>
                    </div>
                </div>
                @foreach($productos as $producto)
                <div class="card d-inline-flex flex-row flex-wrap pl-2l-6 pl-3 pr-1">
                    <div class="align-self-center col-4 col-xl-4 mb-0 mr-0 pl-0 pr-2">
                        <img src= "" width="100" alt="Card image cap">
                    </div>
                    <div class="card-block col-8 pl-0 pr-1">
                        <h6 class="card-title mb-3">Nombre {{$producto->id_producto}}</h6>
                        <input type="hidden" name="idProducto[]" value="{{$producto->id_producto}}">
							<div class="btn-group btn-group-toggle btn-group-sm d-inline input-group pl-0 pr-0" id="selectorUnidades" data-toggle="buttons">
							  <label class="btn btn-secondary">
							    <input type="radio" class="radio_kilos" name="tipoMedida[]" value="kg" checked> Kilos
							  </label>
							 <label class="btn btn-primary active">
							    <input type="radio" class="radio_unidades" name="tipoMedida[]" value="Unidades"> Unidades
							  </label>
							</div>
                        <div class="mb-2 mr-0 pr-1 text-danger text-right d-inline">$ <a class="precio">{{$producto->precio_unidad}}<a/> / <a class="unidad">Unidad</a></div>
                        <input type="hidden" class="otro_precio" value="{{$producto->precio_kg}}">
                        @if($producto->dcto_usar>0)
                        <span class="badge badge-danger badge-pill pl-1 pr-1">{{$producto->dcto_usar*100}} %</span>
                        @endif
                        <div class="mt-2 pl-0 pr-1 divCantidad">
                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                <input type="number"  name="cantidad[]" class="form-control cantidad" placeholder="Cantidad">
                                <div class="input-group-append pr-0">
                                    <span class="input-group-text text-center spanUnidad">&nbsp; uds.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-12">
                        <p class="mb-2 mr-0 pr-10 text-center">TOTAL: $ <a class="monto_producto"></a></p>
                    </div>
                </div>
                    @endforeach
                <div class="bg-white card">
                    <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: $ <a class="monto_total"></a></p>
                        </div>
                        <div class="d-flex pr-2">
                            <button type="submit" id="botonHacerPedido" class="btn btn-success">Hacer pedido
</button>
                        </div>
                         </form>
                    </div>
                </div>
            </div>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


        <!-- include dashboard -->
        @include('errors.custom-message')

        @yield('index')

        <!-- @include('layouts.partials.dashboard')   -->
        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
<script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script type="text/javascript">

function actualizarMontoTotal(){

var montoTotal=0

$('.monto_producto').each(function() {

	if(isNaN(parseFloat($(this).text()))){
		montoTotal=montoTotal+0
	}else{
		montoTotal=montoTotal+parseFloat($(this).text())
	}
});

$('.monto_total').text(montoTotal)

	}

$('input:radio').change(function() {
    if ($(this).val() === 'kg') {

$(this).closest('label').removeClass('btn-secondary')
$(this).closest('label').addClass('btn-primary')
$(this).closest('div').find('.radio_unidades').closest('label').removeClass('btn-primary')
$(this).closest('div').find('.radio_unidades').closest('label').addClass('btn-secondary')
$(this).closest('div').parent().find('.divCantidad').find('.spanUnidad').text('kg.')
$(this).closest('div').parent().find('.divCantidad').find('input').val('')
var precio_kg=$(this).closest('div').parent().find('.otro_precio').val()
var precio_unidad=$(this).closest('div').parent().find('.precio').text()
$(this).closest('div').parent().find('.otro_precio').val(precio_unidad)
$(this).closest('div').parent().find('.precio').text(precio_kg)
$(this).closest('div').parent().find('.unidad').text('kg.')
$(this).closest('div').parent().parent().find('.monto_producto').text('')
actualizarMontoTotal()

    } else if ($(this).val() === 'Unidades') {

$(this).closest('label').removeClass('btn-secondary')
$(this).closest('label').addClass('btn-primary')
$(this).closest('div').find('.radio_kilos').closest('label').removeClass('btn-primary')
$(this).closest('div').find('.radio_kilos').closest('label').addClass('btn-secondary')
$(this).closest('div').parent().find('.divCantidad').find('.spanUnidad').text('uds.')
var precio_unidad=$(this).closest('div').parent().find('.otro_precio').val()
var precio_kilo=$(this).closest('div').parent().find('.precio').text()
$(this).closest('div').parent().find('.otro_precio').val(precio_kilo)
$(this).closest('div').parent().find('.precio').text(precio_unidad)
$(this).closest('div').parent().find('.unidad').text('Unidad')
$(this).closest('div').parent().find('.divCantidad').find('input').val('')
$(this).closest('div').parent().parent().find('.monto_producto').text('')
actualizarMontoTotal()
    }
  });

$(".cantidad").bind("keyup change", function(e) {

    var precio=parseFloat($(this).closest('div').parent().parent().find('.precio').text())
    var monto=($(this).val()*precio).toFixed(2)
	$(this).closest('div').parent().parent().parent().find('.monto_producto').text(monto)
	actualizarMontoTotal()

})

$("#botonHacerPedido").click(function(event){
		event.preventDefault()
        let form = event.target;

        swal.fire({
            title: 'Confirmar pedido',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Cargar pedido'
        }).then((result) => {
        if (result.value) {
            $('#formHacerPedido').submit();
        }
    });
});


</script>



@endsection
