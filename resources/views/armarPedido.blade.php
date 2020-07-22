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
                                                    <th>Unidades a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Kg a entregar</th>
                                                    <th>Stock</th>
                                                    <th>Descuento</th>
                                                    <th>MONTO TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pedido->productos as $productoPedido)
                                            @if(isset($productoPedido->cantidad))
                                                <tr>
                                                    <td>{{$productoPedido->producto->nombre_comercial}}
                                                           <input type="hidden"  name="idProducto[]"  class="form-control" value="{{$productoPedido->id_producto}}">
                                                    </td>
                                                    <td><a class="precio_unidad_pedido">
                                                        @if($productoPedido->tipo_medida=="kg")
                                                            {{$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_kg}}
                                                            </a> / 
                                                            {{$productoPedido->tipo_medida}}
                                                        @elseif($productoPedido->tipo_medida=="Unidades")
                                                        {{$productoPedido->producto->precio()->where('anulado','=',null)->where('fecha_desde','<=',today())->orderBy('fecha_reg','desc')->first()->precio_unidad}}
                                                            </a> / 
                                                            {{$productoPedido->tipo_medida}}
                                                        @else
                                                            error
                                                        @endif
                                                    </td>
                                                    
                                                    <td>{{$productoPedido->cantidad}} <a class="unidad_pedida">{{$productoPedido->tipo_medida}}</a></td>
                                                    <td>
                                                        <div>
                                                            <input type="number"  name="cantidadUnidades[]" min=0 step=1 max="{{$productoPedido->stock_unidades}}" class="form-control unidades_a_enviar" placeholder="Uds. a entregar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; uds.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$productoPedido->stock_unidades}} Unidades</td>
                                                    <td>
                                                        <div>
                                                            <input type="number"  name="cantidadKg[]" min=0 step=0.001 max="{{$productoPedido->stock_kg}}" class="form-control kg_a_enviar" placeholder="Kg. a entregar">
                                                        <div class="input-group-append pr-0">
                                                            <span class="input-group-text text-center">&nbsp; kg.
                                                            </span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$productoPedido->stock_kg}} Kilos</td>
                                                    <td>{{$productoPedido->descuento_pedido}}</td>
                                                    <td>$ <a class="monto_producto"></a></td>
                                                </tr>
                                            @endif
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

    if($(this).closest('td').parent().find('.unidad_pedida').text()=="Unidades"){

        var precio_unidad=parseFloat($(this).closest('td').parent().find('.precio_unidad_pedido').text())
        var monto_producto=($(this).val()*precio_unidad).toFixed(2)
        $(this).closest('td').parent().find('.monto_producto').text(monto_producto)
    }
actualizarMontoTotal()


})
$(".kg_a_enviar").bind("keyup change", function(e) {

    if($(this).closest('td').parent().find('.unidad_pedida').text()=="Kg."){

        var precio_unidad=parseFloat($(this).closest('td').parent().find('.precio_unidad_pedido').text())
        var monto_producto=($(this).val()*precio_unidad).toFixed(2)
        $(this).closest('td').parent().find('.monto_producto').text(monto_producto)
    }
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




