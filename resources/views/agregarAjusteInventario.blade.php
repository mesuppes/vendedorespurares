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
                                  @if(session('error'))
                                  <div class="alert alert-danger" role="alert">
                            {{$msg}}
                            </div>
                                  @endif
                                    <form method="POST" id="formAgregarAjuste" class="needs-validation" action="{{route('ajustes.store')}}">
                                        @csrf
                                        <p>No deberán realizarse armados de pedidos mientras se ajusta el stock.</p>
										<input type="hidden"  name="lastIdMov"  class="form-control" value="{{$lastIdMov}}">
                                           <div class="form-group">
                                                <label>Motivo:</label>
                                                <textarea rows="5" name="motivo" class="form-control border-input" placeholder="Describa el motivo de ajuste" required></textarea >
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
                                                @foreach ($productosLote as $producto)
                                            <tr>
                                                <td class="tdnombreproducto">
 												<input type="hidden"  name="idProducto[]"  class="form-control" value="{{$producto['id_producto']}}">
                                                {{$producto->producto->nombre_comercial}}</td>
                                                <td>
                                                	<input type="hidden"  name="loteCompra[]"  class="form-control" value="{{$producto['lote_compra']}}">
                                                	<input type="hidden"  name="loteProduccion[]"  class="form-control" value="{{$producto['lote_produccion']}}">
                                                    @if($producto['lote_produccion']==Null)
                                                    C {{$producto['lote_compra']}}
                                                    @else
                                                    P {{$producto['lote_produccion']}}
                                                    @endif
                                                </td>
                                                <td class="stockkilos"><a>{{$producto['stock_kg']}}</a> kg.</td>

                                                <td>
                                                    <div class="input-group">
                                                                    <input type="number"  min=0 step=0.001 class="form-control inputkilos inputajuste" placeholder="Kilos actuales">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center ">&nbsp; kilos.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                </td>
                                                	<input type="hidden"  name="pesoKg[]"  class="form-control inputkilosaenviar">
                                                <td class="diferenciakilos">
                                                </td>
                                                <td class="stockunidades"><a>{{$producto['stock_unidades']}}</a> unidades</td>
                                                <td>
                                                     <div class="input-group">
                                                                    <input type="number" min=0 step=1 class="form-control inputunidades inputajuste" placeholder="Unidades actuales">
                                                                <div class="input-group-append pr-0">
                                                                    <span class="input-group-text text-center">&nbsp; unidades.
                                                                    </span>
                                                                </div>
                                                                </div>
                                                </td>
                                                		<input type="hidden"  name="unidades[]" class="form-control inputunidadesaenviar">
                                                <td class="diferenciaunidades">
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

        var productosAjustar=[];
        var cantidadnuevaunidades=[];
        var cantidadnuevakilos=[];

		$('.tdnombreproducto').each(function(){
       		 	productosAjustar.push($(this).text())
       		})
		$('.inputunidades').each(function(){
       		 if($(this).val()!=0){
       		 	cantidadnuevaunidades.push($(this).val())
       		 }else{
       		 	cantidadnuevaunidades.push('0')
       		 }
       		})
      	$('.inputkilos').each(function(){
       		 if($(this).val()!=0){
       		 	cantidadnuevakilos.push($(this).val())
       		 }else{
       		 	cantidadnuevakilos.push('0')
       		 }
       		})



		if(productosAjustar.length>0){
				var tablaProductosAjuste = $('<table class="table"><thead><th class="text-left">Productos</th><th>Cantidad Unidades</th><th>Cantidad Kilos</th></thead><tbody></tbody></table>')
				for (var i = 0; i < productosAjustar.length; i++) {
					if(cantidadnuevaunidades[i]!=0||cantidadnuevakilos[i]!=0){
					tablaProductosAjuste.find('tbody').append('<tr><td class="text-left">'+productosAjustar[i]+'</td><td>'+cantidadnuevaunidades[i]+' unidades</td><td>'+cantidadnuevakilos[i]+' kilos</td></tr>')
					}
				}
			}

          swal.fire({
            title: 'Confirmar ajuste',
            html: 'Ajuste<br>'+$('<div></div>').html(tablaProductosAjuste).html(),
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Cargar ajuste'
        }).then((result) => {
        if (result.value) {
            $('#formAgregarAjuste').submit();
        }
    });
    }
      }, false);
    });
  }, false);
})();

$(".inputkilos").bind("keyup change", function(e) {



 var kilosactual=$(this).closest('td').parent().find('.stockkilos a').text();
 var kilosnuevo=$(this).val();

 if(kilosnuevo!=''){
 if(kilosnuevo-kilosactual<0){

  	$(this).closest('td').parent().find('.diferenciakilos').removeClass('text-success')
  	$(this).closest('td').parent().find('.diferenciakilos').addClass('text-danger')
  	$(this).closest('td').parent().find('.diferenciakilos').text((kilosnuevo-kilosactual).toFixed(3)+' kilos');
  	$(this).closest('td').parent().find('.inputkilosaenviar').val((kilosnuevo-kilosactual).toFixed(3))
}else{
	$(this).closest('td').parent().find('.diferenciakilos').removeClass('text-danger')
	$(this).closest('td').parent().find('.diferenciakilos').addClass('text-success')
	$(this).closest('td').parent().find('.diferenciakilos').text('+ '+(kilosnuevo-kilosactual).toFixed(3)+' kilos');
    $(this).closest('td').parent().find('.inputkilosaenviar').val((kilosnuevo-kilosactual).toFixed(3))
}
}else{
		$(this).closest('td').parent().find('.diferenciakilos').text('');
		$(this).closest('td').parent().find('.inputkilosaenviar').val('')
}
})

$(".inputunidades").bind("keyup change", function(e) {


 var unidadesactual=$(this).closest('td').parent().find('.stockunidades a').text();
 var unidadesnuevo=$(this).val();

 if(unidadesnuevo!=''){
 if(unidadesnuevo-unidadesactual<0){
 	$(this).closest('td').parent().find('.diferenciaunidades').removeClass('text-success')
  	$(this).closest('td').parent().find('.diferenciaunidades').addClass('text-danger')
  	$(this).closest('td').parent().find('.diferenciaunidades').text((unidadesnuevo-unidadesactual).toFixed(0)+' unidades');
  	$(this).closest('td').parent().find('.inputunidadesaenviar').val((unidadesnuevo-unidadesactual).toFixed(0))
}else{
	$(this).closest('td').parent().find('.diferenciaunidades').removeClass('text-danger')
	$(this).closest('td').parent().find('.diferenciaunidades').addClass('text-success')
	$(this).closest('td').parent().find('.diferenciaunidades').text('+ '+(unidadesnuevo-unidadesactual).toFixed(0)+' unidades');
	$(this).closest('td').parent().find('.inputunidadesaenviar').val((unidadesnuevo-unidadesactual).toFixed(0))
}
}else{
	$(this).closest('td').parent().find('.diferenciaunidades').text('');
	$(this).closest('td').parent().find('.inputunidadesaenviar').val('')
}
})


</script>

        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




