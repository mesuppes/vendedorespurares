

<h1>estas por agregar un pedido</h1>

@if($errors->any())
	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
@endif

<form method="POST" action="{{route('pedido.store')}}">
	@csrf
	<label>
		Id Vendedor
		<input type="text" name="idVendedor"><br>
	</label>
	<br>	
	<label>
		Forma de entrega
		<input type="text" name="formaEntrega"><br>
	</label>
	<br>	
	<label>
		Datos del Flete
		<input type="text" name="datosFlete"><br>
	</label>
	<br>	
	<label>
		Condición de pago
		<input type="text" name="condicionPago"><br>
	</label>
	<br>
	<button>Crear Formulario</button>
</form>
