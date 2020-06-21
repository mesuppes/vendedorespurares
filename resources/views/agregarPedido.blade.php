

<h1>estas por agregar un pedido</h1>

{{$productos}}

@if($errors->any())
	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
@endif

<form method="POST" action="{{route('pedido.store')}}">
	@csrf

	### DEBE PODER SELECCIONAR EL VENDEDOR SOLO SI TINE PERMISO -> CARGAR PEDIDO A OTROS VENDEDORES ###

	<label>
		Id Vendedor
		<input type="text" name="idVendedor" value="1"><br>
	</label>
	<br>	
	<label>
		Forma de entrega
		<input type="text" name="formaEntrega" value="mano"><br>
	</label>
	<br>	
	<label>
		Datos del Flete
		<input type="text" name="datosFlete" value="derecha"><br>
	</label>
	<br>	
	<label>
		Condición de pago
		<input type="text" name="condicionPago"  value="tarjeta"><br>
	<br><br>
		ID productos
		<input type="number" name="idProducto[]" value="1" ><br>
		<input type="number" name="idProducto[]" value="2" ><br>
		<input type="number" name="idProducto[]" value="3" ><br>
	<br><br>
		Tipo Medida
		<input type="text" name="tipoMedida[]" value="Kg" ><br>
		<input type="text" name="tipoMedida[]" value="unidades" ><br>
		<input type="text" name="tipoMedida[]" value="unidades" ><br>
	<br><br>
		precio Unitario
		<input type="number" name="cantidad[]" value="100" ><br>
		<input type="number" name="cantidad[]" value="200" ><br>
		<input type="number" name="cantidad[]" value="300" ><br>

	</label>
	<br>
	<button>Crear Formulario</button>
</form>
