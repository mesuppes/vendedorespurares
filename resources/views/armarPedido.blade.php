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
                                    <h5 class="card-title">Datos del pedido</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="formArmarPedido" action="{{route('armarPedido.store')}}">
                                        @csrf
                                         <input type="hidden"  name="idPedido"  class="form-control" value="{{$pedido->id_pedido}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled placeholder="Vendedor" value="{{$pedido->vendedor['nombre']}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la condición del pago" value="{{$pedido->condicion_pago}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la forma de entrega" value="{{$pedido->forma_entrega}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese los datos del flete" value="{{$pedido->datos_flete}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
                                <div class="card-header">
                                    <h5 class="card-title">Productos pedidos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad pedida</th>
                                                    <th>Lote</th>
                                                    <th>Unidades a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Kg a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Descuento</th>
                                                    <th>MONTO TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	   @php
                                               $numerotrproducto=0
                                            @endphp
                                            @foreach($pedido->productos as $productoPedido)
                                            @php
                                               $i=0;
                                            @endphp
                                                        <tr>
                                                @foreach($productoPedido->producto->stockLote as $loteProducto)
                                                    @if(isset($productoPedido->cantidad))
                                                    @php
                                                    $z=$productoPedido->producto->stockLote->count()
                                                    @endphp
                                                            <!--PRODUCTO-->
                                                            @if($i==0)
                                                            <td rowspan="{{$z}}">
                                                                {{$productoPedido->producto->nombre_comercial}}
                                                                <input type="hidden"  name="idProducto[]"  class="form-control" value="{{$productoPedido->id_producto}}">
                                                            </td>
                                                            @endif

                                                            <!--PRECIO-->
                                                            @if($i==0)
                                                            <td rowspan="{{$z}}">
                                                                <a>$
                                                                @if($productoPedido->tipo_medida=="kg")
                                                                    {{$precio=$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_kg}} / kg
                                                                    </a>
                                                                @elseif($productoPedido->tipo_medida=="Unidades")
                                                                    {{$precio=$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_unidad}} / Unidad
                                                                    </a>
                                                                @else
                                                                    error
                                                                @endif
                                                            <input type="hidden"  name="precio[]"  class="form-control" value="{{$precio}}">
                                                            <input type="hidden"  name="tipoMedida[]"  class="form-control" value="{{$productoPedido->tipo_medida}}">
                                                            </td>
                                                            @endif


                                                            <!--CANTIDAD PEDIDA-->
                                                            @if($i==0)
                                                            <td rowspan="{{$z}}">
                                                                {{$productoPedido->cantidad}} <a>{{$productoPedido->tipo_medida}}</a>
                                                            </td>
                                                            @endif

                                                           <!--LOTE (PROD/COMPRA)-->
                                                            <td>
                                                                @if(isset($loteProducto->lote_compra))
                                                                    <b>C-</b>
                                                                @elseif(isset($loteProducto->lote_produccion))
                                                                    <b>P-</b>
                                                                @endif

                                                                {{$loteProducto->lote_produccion}}
                                                                <input type="hidden"  name="loteProduccion[]"  class="form-control" value="{{$loteProducto->lote_produccion}}">
                                                                 <input type="hidden" class="unidad_pedida" value="{{$productoPedido->tipo_medida}}">
                                                                 <input type="hidden" class="precio_unidad_pedido" value="
                                                                 @if($productoPedido->tipo_medida=="kg")
                                                                    {{$precio=$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_kg}}
                                                                @elseif($productoPedido->tipo_medida=="Unidades")
                                                                    {{$precio=$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_unidad}}
                                                                 @endif
                                                                    ">
                                                                {{$loteProducto->lote_compra}}
                                                                <input type="hidden"  name="loteCompra[]"  class="form-control" value="{{$loteProducto->lote_compra}}">
                                                            </td>

                                                            <!--UNIDADES A ENTREGAR-->
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number"  name="cantidadUnidades[]" min=0 step=1 max="{{$productoPedido->stock_unidades}}" class="form-control unidades_a_enviar inputUnidades{{$numerotrproducto}}" id="{{$numerotrproducto}} unit" placeholder="Uds. a entregar">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center">&nbsp; uds.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                            </td>

                                                            <!--STOCK UNIDADES-->
                                                            <td>
                                                                {{$loteProducto->stock_unidades}} Unidades
                                                            </td>

                                                            <!--KG A ENTREGAR-->
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number"  name="cantidadKg[]" min=0 step=0.001 max="{{$productoPedido->stock_kg}}" class="form-control kg_a_enviar inputKilos{{$numerotrproducto}}" id="{{$numerotrproducto}} kilo" placeholder="Kg. a entregar">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center">&nbsp; kg.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                            </td>

                                                            <!--STOCK KG-->
                                                            <td>
                                                                {{$loteProducto->stock_kg}} Kilos
                                                            </td>

                                                            <!--DESCUENTO-->
                                                            <td>
                                                                {{$productoPedido->descuento*100}} %
                                                            </td>

                                                                <input type="hidden"  name="descuento[]"  class="form-control" value="{{$productoPedido->descuento}}">

                                                            <!--MONTO TOTAL-->
                                                            <td>
                                                                $ <a class="monto_producto montoTotalLote{{$numerotrproducto}}"></a>
                                                            </td>

                                                    @endif
                                                        </tr>
                                                @php
                                                $i=$i+1
                                                @endphp
                                                @endforeach
									<tr class="{{$numerotrproducto}}">
                                                <td colspan="4" class="text-right">Sub total:</td>
                                                <td class="tdSubtotalUnidades"></td>
                                                <td></td>
                                                <td class="tdSubtotalKilos"></td>
                                                <td></td>
                                                <td></td>
                                                <td class="tdSubtotalMonto"></td>
									</tr>
									@php
									$numerotrproducto=$numerotrproducto+1
									@endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
</div>
  <div class="bg-white card col-12">
                    <div class="d-inline-flex justify-content-between">
                        <div class="align-items-end d-flex pl-3">
                            <p>TOTAL: <a class="monto_total"></a></p>
                        </div>
                        <div class="d-flex pr-2">
                            <button type="submit" id="" class="btn btn-success">Armar pedido
</button>
                        </div>
                    </form>
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

$(".unidades_a_enviar").bind("keyup change", function(e) {

    if($(this).closest('td').parent().find('.unidad_pedida').val()=="Unidades"){

        var precio_unidad=parseFloat($(this).closest('td').parent().find('.precio_unidad_pedido').val())
        var monto_producto=($(this).val()*precio_unidad).toFixed(2)
        $(this).closest('td').parent().find('.monto_producto').text(monto_producto)
    }
       var id=$(this).attr('id')
	   var numerotr=id.substring(0, id.length - 5)

	   var subtotalUnidades=0

		$(".inputUnidades"+numerotr).each(function() {

    		if(isNaN(parseFloat($(this).val()))){
        		subtotalUnidades=subtotalUnidades+0
    		}else{
        		subtotalUnidades=subtotalUnidades+parseFloat($(this).val())
    		}
		});
		subtotalUnidades=subtotalUnidades.toFixed(0)

	   $(this).closest('tr').siblings("."+numerotr).find('.tdSubtotalUnidades').html(subtotalUnidades+' unidades')

	      var subtotalMontoProducto=0

	   $(".montoTotalLote"+numerotr).each(function() {

    		if(isNaN(parseFloat($(this).text()))){
        		subtotalMontoProducto=subtotalMontoProducto+0
    		}else{
        		subtotalMontoProducto=subtotalMontoProducto+parseFloat($(this).text())
    		}
		});
		subtotalMontoProducto=subtotalMontoProducto.toFixed(2)

	   $(this).closest('tr').siblings("."+numerotr).find('.tdSubtotalMonto').html('$ '+ subtotalMontoProducto)

actualizarMontoTotal()

})
$(".kg_a_enviar").bind("keyup change", function(e) {

    if($(this).closest('td').parent().find('.unidad_pedida').val()=="Kg."){

        var precio_unidad=parseFloat($(this).closest('td').parent().find('.precio_unidad_pedido').val())
        var monto_producto=($(this).val()*precio_unidad).toFixed(2)
        $(this).closest('td').parent().find('.monto_producto').text(monto_producto)
    }
     	var id=$(this).attr('id')
	   var numerotr=id.substring(0, id.length - 5)

	   var subtotalKilos=0

		$(".inputKilos"+numerotr).each(function() {

    		if(isNaN(parseFloat($(this).val()))){
        		subtotalKilos=subtotalKilos+0
    		}else{
        		subtotalKilos=subtotalKilos+parseFloat($(this).val())
    		}
		});
		subtotalKilos=subtotalKilos.toFixed(3)

	   $(this).closest('tr').siblings("."+numerotr).find('.tdSubtotalKilos').html(subtotalKilos+' kilos')

	   var subtotalMontoProducto=0

	   $(".montoTotalLote"+numerotr).each(function() {

    		if(isNaN(parseFloat($(this).text()))){
        		subtotalMontoProducto=subtotalMontoProducto+0
    		}else{
        		subtotalMontoProducto=subtotalMontoProducto+parseFloat($(this).text())
    		}
		});
		subtotalMontoProducto=subtotalMontoProducto.toFixed(2)

	   $(this).closest('tr').siblings("."+numerotr).find('.tdSubtotalMonto').html('$ '+ subtotalMontoProducto)

actualizarMontoTotal()
})

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
$('.monto_total').text('$ '+montoTotal)

    }

</script>



</div>
</div>




