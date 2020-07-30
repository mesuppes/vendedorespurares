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
                            <div class="alert
                            @if($wf->status==2||$wf->status==4)
                            alert-success
                            @elseif($wf->status==1)
                            alert-warning
                            @elseif($wf->status==3||$wf->status==6)
                            alert-danger
                            @endif
                             " role="alert">
                            {{$msjStatus}}
                            @if($wf->status==6)
                            <br>
                            <b>Motivo:</b>
                            {{$pedidoDescUltimo->motivo_baja}}
                            @endif
                            </div>
                                <div class="card-header d-flex">
                                    <h5 class="card-title">Datos del pedido
                                    <span class="badge badge-warning">{{$wf->statusN->nombre}}</span>
                                    </h5>

                                    @if($accion=='si')

                                    <a href="{{route('pedido.armar', $pedidoDescUltimo->id_pedido)}}"  class="btn btn-sm btn-success ml-auto">Armar pedido
                                    </a>

                                    @endif
                                    @if(isset($idFacturaProforma))
                                        <a  href="{{route('facturaProforma.show', $idFacturaProforma)}}"
                                            class="btn btn-sm btn-danger ml-auto">Ver factura
                                        </a>
                                    @else
                                        @if($wf->status!=6)
                                        <a  class="btn btn-sm btn-danger ml-auto" data-toggle="modal" data-target="#modalRechazarPedido">Rechazar pedido
                                        </a>
                                        @endif
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled placeholder="Vendedor" value="{{$pedidoDescUltimo->vendedor['nombre']}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la condición del pago" value="{{$pedidoDescUltimo->condicion_pago}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese la forma de entrega" value="{{$pedidoDescUltimo->forma_entrega}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" disabled placeholder="Ingrese los datos del flete" value="{{$pedidoDescUltimo->datos_flete}}">
                                                </div>
                                            </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <textarea class="form-control" readonly placeholder="No hay comentario">{{$pedidoDescUltimo->comentarios}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        </div>
                                    </form>
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
                                                    <th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $precioTotalPedido=0
                                                @endphp
                                                @foreach($pedidoProdUltimo as $producto)
                                                <tr>
                                                    <td>{{$producto->producto->nombre_comercial}}</td>
                                                    <td>${{$producto->precio_unitario}}/{{$producto->tipo_medida}}</td>
                                                    <td>
                                                        <div class="mb-1">
                                                            {{$producto->cantidad}} {{$producto->tipo_medida}}
                                                        </div>
                                                    </td>
                                                    <td>${{$producto->precio_final}}</td>
                                                </tr>
                                                @php
                                                $precioTotalPedido=$precioTotalPedido+$producto->precio_final
                                                @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>TOTAL</th>
                                                    <th>$ {{$precioTotalPedido}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<div class="modal fade" id="modalRechazarPedido" tabindex="-1" role="dialog" aria-labelledby="modal de rechazo de pedido" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rechazar pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" name="formRechazarPedido" action="{{route('pedido.rechazar', $pedidoDescUltimo->id_pedido)}}">
        @csrf
         <div class="form-group">
            <label>Motivo</label>
            <textarea class="form-control" name="motivoBaja" placeholder="Ingrese el motivo por el que rechazará el pedido..."></textarea>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="" class="btn btn-danger">Rechazar pedido</button>
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

@if(session('pedidoAgregado'))

    <script type="text/javascript">
 swal.fire({
            title: 'Pedido agregado',
            showCancelButton: false,
            html: '{{session('pedidoAgregado')}}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        })

</script>
                @endif

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




