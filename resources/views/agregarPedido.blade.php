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
                            <h5 class="card-title">Datos del pedido de {{$vendedor->nombre}} {{$vendedor->apellidos}}</h5>
                        @endisset
                        @empty($vendedor)
                            <h5 class="card-title">Datos del pedido</h5>
                        @endempty
                    </div>
                    <div class="card-body">
                        <form method="POST" id="formHacerPedido" action="{{route('pedido.store')}}" class="needs-validation">
							     @csrf
							    <input type="hidden" name="idVendedor" value="{{$vendedor->id_vendedor}}">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
										 <label for="condicionPago">Condición del pago</label>
                                            <select class="selectpicker form-control"  data-style="btn btn-danger btn-block"  name="condicionPago">
                                              <option value="" selected>Seleccione condición de pago</option>
                                              <option value="Contado">Contado</option>
                                              <option value="Valores">Valores</option>
     										  <option value="Deposito">Deposito</option>
                                              <option value="Transferencia">Transferencia</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
 										<label for="formaEntrega">Forma de entrega</label>
                                            <select class="selectpicker form-control"  data-style="btn btn-danger btn-block"  name="formaEntrega">
                                              <option value="" selected>Seleccione forma de entrega</option>
                                              <option value="Purares">Purares</option>
                                              <option value="Retira en fábrica">Retira en fábrica</option>
     										  <option value="Transporte de terceros">Transporte de terceros</option>
                                              <option value="Comisionista">Comisionista</option>
                                            </select>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
										<label for="datosFlete">Datos del flete</label>
                                            <select class="selectpicker form-control"  data-style="btn btn-danger btn-block"   name="datosFlete" >
                                              <option selected value="">Seleccione datos del flete</option>
                                              <option value="Frio">Con frío</option>
                                              <option value="Sin Frio">Sin frio</option>
                                            </select>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentario</label>
                                                    <textarea class="form-control" name="comentarios"  placeholder="Ingrese algún comentario"></textarea>
                                                </div>
                                            </div>
                                </div>
                            </div>
                             </div>
                            </div>
                            </div>

                <div class="bg-white card card-user">
                    <div class="card-header">
                        <h5 class>Productos</h5>
                      {{$vendedor->inscripcion_afip}}

                    </div>
                </div>
                    @if(old('cantidad'))
                    @for( $i =0; $i < count(old('cantidad')); $i++)
                   @php $i=0;
                       $decGeneralObj=$vendedor->descuentoGeneral()->orderBy('id','desc')->first();
                      if (isset($decGeneralObj)) {
                        $decGeneral=$decGeneralObj->descuento->descuento;
                      }else{
                        $decGeneral=0;
                      }
                      @endphp


                @foreach($productos as $producto)
    @if(isset($producto->precioActual))
    @if(isset($producto->stock->stock_kg) || isset($producto->stock->stock_unidades))
                   @php
        			$productoDescuento=$vendedor->descuentoProductos()->where('id_producto','=',$producto->id_producto)->first();
        			if (isset($productoDescuento)) {
       				 $descuento=$productoDescuento->descuento;
        			}else{
            			$descuento=$decGeneral;
       					 }
   				 @endphp
                <div class="card bg-white d-inline-flex col-12 flex-row flex-wrap pl-2l-6 pl-3 pr-1">
                    <div class="align-self-center col-4 col-xl-4 mb-0 mr-0 pl-0 pr-2">
                        <img src= "{{$producto->url_foto}}" width="100" alt="Imagen de {{$producto->nombre_comercial}}">
                    </div>
                    <div class="card-block col-8 pl-0 pr-1">
                        <h6 class="card-title mb-3">{{$producto->nombre_comercial}}</h6>
                        <input type="hidden" name="idProducto[]" value="{{$producto->id_producto}}">
							<div class="btn-group btn-group-toggle btn-group-sm d-inline input-group pl-0 pr-0" id="selectorUnidades" data-toggle="buttons">
							  <label class="
							  @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
							  	btn btn-primary active
							  @else
								btn btn-secondary
							  @endif
							  ">
							    <input type="radio" class="radio_kilos" name="tipoMedida[{{$i}}]"  autocomplete="off" value="kg"
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								checked
							  @else
								disabled
							  @endif
							    > Kilos
							  </label>
							 <label class="
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								btn btn-secondary
							  @else
								btn btn-primary active
							  @endif
							 ">
							    <input type="radio" class="radio_unidades" name="tipoMedida[{{$i}}]"  autocomplete="off" value="Unidades"
									@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								disabled
							  @else
								checked
							  @endif
							    > Unidades
							  </label>
							</div>
                        <div class="mb-2 mr-0 pr-1 text-danger text-right d-inline">$ <a class="precio">
 							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								{{$producto->precioActual->precio_kg}}
							  @else
								{{$producto->precioActual->precio_unidad}}
							  @endif
                        	<a/> / <a class="unidad">Unidad</a></div>
                        <input type="hidden" class="otro_precio" value="{{$producto->precio_kg}}">
                        <input type="hidden" class="otro_stock" value="{{$producto->stock_kg}}">
                        @if($descuento>0)
                        <span class="badge badge-danger badge-pill pl-1 pr-1"><a class="descuento">{{$descuento*100}}</a> %</span>
                        @endif
                        <br>
                        <div class="mb-2 mr-0 pr-1 text-right d-inline">Stock Actual <a class="stock">
							 @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								{{$producto->stock->stock_kg}}
							  @else
								{{$producto->stock->stock_unidades}}
							  @endif
                        	<a/> <a class="unidadstock">
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								Kilos
							  @else
								Unidades
							  @endif
                        	</a></div>
                        <div class="mt-2 pl-0 pr-1 divCantidad">
                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                <input type="number"  name="cantidad[]" value="{{ old('cantidad.'.$i)}}" min=0 max=
                               @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								{{$producto->stock->stock_kg}}
							  @else
								{{$producto->stock->stock_unidades}}
							  @endif
                                 class="form-control cantidad" placeholder="Cantidad">
                                <div class="input-group-append pr-0">
                                    <span class="input-group-text text-center spanUnidad">&nbsp;
									@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
									kg.
							  		@else
									uds.
							  		@endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-12">
                        <p class="mb-2 mr-0 pr-10 text-center">TOTAL: $ <a class="monto_producto"></a></p>
                    </div>
                </div>
                     @php $i++
                     @endphp
    @endif
    @endif
                    @endforeach
                    @endfor
                    @else
                      @php $i=0;
                          $decGeneralObj=$vendedor->descuentoGeneral()->orderBy('id','desc')->first();
                      if (isset($decGeneralObj)) {
                        $decGeneral=$decGeneralObj->descuento->descuento;
                      }else{
                        $decGeneral=0;
                      }
                     @endphp
                @foreach($productos as $producto)
  @if(isset($producto->precioActual))
  @if(isset($producto->stock->stock_kg) || isset($producto->stock->stock_unidades))
                 @php
        			$productoDescuento=$vendedor->descuentoProductos()->where('id_producto','=',$producto->id_producto)->first();
        			if (isset($productoDescuento)) {
       				 $descuento=$productoDescuento->descuento;
        			}else{
            			$descuento=$decGeneral;
       					 }
   				 @endphp
                <div class="card d-inline-flex flex-row col-12 flex-wrap pl-2l-6 pl-3 pr-1">
                    <div class="align-self-center col-4 col-xl-4 mb-0 mr-0 pl-0 pr-2">
                        <img src= "{{$producto->url_foto}}" width="100" alt="Imagen de {{$producto->nombre_comercial}}">
                    </div>
                    <div class="card-block col-8 pl-0 pr-1">
                        <h6 class="card-title mb-3">{{$producto->nombre_comercial}}</h6>
                        <input type="hidden" name="idProducto[]" value="{{$producto->id_producto}}">
                            <div class="btn-group btn-group-toggle btn-group-sm d-inline input-group pl-0 pr-0" id="selectorUnidades" data-toggle="buttons">
                              <label class="
                              @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
							  	btn btn-primary active
							  @else
								btn btn-secondary
							  @endif
                              ">
                                <input type="radio" class="radio_kilos" name="tipoMedida[{{$i}}]"  autocomplete="off" value="kg"
 							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								checked
							  @else
								disabled
							  @endif
                                > Kilos
                              </label>
                             <label class="
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								btn btn-secondary
							  @else
								btn btn-primary active
							  @endif
                             ">
                                <input type="radio" class="radio_unidades" name="tipoMedida[{{$i}}]"  autocomplete="off" value="Unidades"
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								disabled
							  @else
								checked
							  @endif
                                > Unidades
                              </label>
                            </div>
                        <div class="mb-2 mr-0 pr-1 text-danger text-right d-inline">$ <a class="precio">
							@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								{{$producto->precioActual->precio_kg}}
							  @else
								{{$producto->precioActual->precio_unidad}}
							  @endif
                        	<a/> / <a class="unidad">Unidad</a></div>
                        <input type="hidden" class="otro_precio" value="{{$producto->precio_kg}}">
                        <input type="hidden" class="otro_stock" value="{{$producto->stock_kg}}">
                        @if($descuento>0)
                        <span class="badge badge-danger badge-pill pl-1 pr-1"><a class="descuento">{{$descuento*100}}</a> %</span>
                        @endif
                        <br>
                        <div class="mb-2 mr-0 pr-1 text-right d-inline">Stock Actual <a class="stock">
							 @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								{{$producto->stock->stock_kg}}
							  @else
								{{$producto->stock->stock_unidades}}
							  @endif
                        	<a/> <a class="unidadstock">
                        		@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
								Kilos
							  @else
								Unidades
							  @endif
                        	</a></div>
                        <div class="mt-2 pl-0 pr-1 divCantidad">
                            <div class="col-md-6 col-xl-6 d-inline-flex input-group pl-0 pr-0">
                                <input type="number"  name="cantidad[]" min=0 max=
								   @if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
										{{$producto->stock->stock_kg}}
							  		@else
								{{$producto->stock->stock_unidades}}
							  		@endif
                                 class="form-control cantidad" placeholder="Cantidad">
                                <div class="input-group-append pr-0">
                                    <span class="input-group-text text-center spanUnidad">&nbsp;
								@if($vendedor->inscripcion_afip=="M"||$vendedor->inscripcion_afip=="RI")
									kg.
							  		@else
									uds.
							  		@endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-12">
                        <p class="mb-2 mr-0 pr-10 text-center">TOTAL: $ <a class="monto_producto"></a></p>
                    </div>
                </div>
                     @php $i++
                     @endphp
@endif
@endif
                    @endforeach
                    @endif
                <div class="bg-white card">
                    <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: $ <a class="monto_total"></a></p>
                        </div>
                            @role('Administracion')
						    <div class="form-check align-self-center ">
						      <label class="form-check-label">
						          <input class="form-check-input" type="checkbox" name="requiereAprobacion">
						          Requiere aprobacion del vendedor
						          <span class="form-check-sign">
						            <span class="check"></span>
						          </span>
						      </label>
                            </div>
                            @endrole
                        <div class="d-flex pr-2">
   <button type="submit" class="btn btn-success" id="botonHacerPedido" >Hacer pedido</button>
                        </div>

		     </div>
                         </form>
                    </div>
      <script>
      	(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {

      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }else{
         event.preventDefault();
        form.classList.add('was-validated');

        var productosPedidos=[];
        var cantidadPedida=[];
        var montos=[];

		$('.cantidad').each(function(){
       		 if($(this).val()!=0){
			 productosPedidos.push($(this).closest('div').parent().parent().parent().find('.card-title').text())
       		 cantidadPedida.push($(this).val()+' '+$(this).closest('div').find('.spanUnidad').text())
       		 montos.push('$ '+parseFloat($(this).closest('div').parent().parent().parent().find('.monto_producto').text()))

                                  }})
		if(productosPedidos.length>0){
				var tablaProductosPedidos = $('<table class="table"><thead><th class="text-left">Productos</th><th>Cantidad</th><th>Monto</th></thead><tbody></tbody></table>')
				for (var i = 0; i < productosPedidos.length; i++) {
					tablaProductosPedidos.find('tbody').append('<tr><td class="text-left">'+productosPedidos[i]+'</td><td>'+cantidadPedida[i]+'</td><td>'+montos[i]+'</td></tr>')
				}
			}

          swal.fire({
            title: 'Confirmar pedido',
            html: 'Pedido de {{$vendedor->nombre}} {{$vendedor->apellidos}}'+
                   '<br>La condición de pago es '+$('select[name=condicionPago] option:selected').text()+
                   '<br>La forma de entrega es '+$('select[name=formaEntrega] option:selected').text()+
                   '<br>Datos de flete: '+$('select[name=datosFlete] option:selected').text()+
                   '<br>'+$('textarea[name=comentarios]').val()+
                   '<br>'+$('<div></div>').html(tablaProductosPedidos).html(),
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Cargar pedido'
        }).then((result) => {
        if (result.value) {
            $('#formHacerPedido').submit();
        }
    });
    }
      }, false);
    });
  }, false);
})();

      </script>
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

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.2.0/bootstrap-4.css"></link>
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
montoTotal=montoTotal.toFixed(2)
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

var stock_kg=$(this).closest('div').parent().find('.otro_stock').val()
var stock_unidad=$(this).closest('div').parent().find('.stock').text()
$(this).closest('div').parent().find('.otro_stock').val(stock_unidad)
$(this).closest('div').parent().find('.stock').text(stock_kg)
$(this).closest('div').parent().find('.unidadstock').text('kilos')
$(this).closest('div').parent().find('.divCantidad').find('.cantidad').attr('max',stock_kg)
$(this).closest('div').parent().find('.divCantidad').find('.cantidad').attr('step','0.001')

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

var stock_unidad=$(this).closest('div').parent().find('.otro_stock').val()
var stock_kilo=$(this).closest('div').parent().find('.stock').text()
$(this).closest('div').parent().find('.otro_stock').val(stock_kilo)
$(this).closest('div').parent().find('.stock').text(stock_unidad)
$(this).closest('div').parent().find('.unidadstock').text('Unidades')
$(this).closest('div').parent().find('.divCantidad').find('.cantidad').attr('max',stock_unidad)
$(this).closest('div').parent().find('.divCantidad').find('.cantidad').attr('step','1')

$(this).closest('div').parent().find('.divCantidad').find('input').val('')
$(this).closest('div').parent().parent().find('.monto_producto').text('')
actualizarMontoTotal()
    }
  });

$(".cantidad").bind("keyup change", function(e) {

    var precio=parseFloat($(this).closest('div').parent().parent().find('.precio').text())
    var precioDescuento=precio*(1-(parseFloat($(this).closest('div').parent().parent().find('.descuento').text()/100)))
    var monto=($(this).val()*precioDescuento).toFixed(2)
	$(this).closest('div').parent().parent().parent().find('.monto_producto').text(monto)
	actualizarMontoTotal()

})



</script>



@endsection
