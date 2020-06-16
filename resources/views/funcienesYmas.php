
<?php 

//ESTA ES LA FORMA DE CONSULTAR LA BD

	//OPCIÓN 1
	$consultaBD= /BD::table('tablaAconsultar')->get();

	//OPCIÓN 2
	use DB; //importa la clase, esto se pone al inicio de la hoja CON ESTO EVITAMOS LA /
	$consultaBD= BD::table('tablaAconsultar')->get(); // EL MÉTODO GET TRAE TODO LOS DATOS

	//Como resultado tenemos un objeto, para tratarlo como un array debemos acceder de la siguiete forma:

	$consultaBD->titulo; //debe ser el nombre de la columna con la que se retorna

//LARAVEL TIENE ELOQUENT -> es un ORM (object-realtional-mapping) -> se trata de mapear  datos BD => clase/objeto PHP , y biceversa


	//CONSOLE:
	php artisan make:model -h // -h es para ver la ayuda

	php artisan make:model MyModel -m //Con este comando te evitas de crear la migración manualment

	#Una vez creado el modelo lo podemos ver desde la carpeta app
	#Se crea una clase que hereda todas las funcionalidades de un modelo de eloquent
	#para definir la tabla: (siempre dentro de la clase)

	class NombreTabla extends model {
		protected $table = 'myTable'; #en caso de que la tabla no tenga el nombre de la clase+s
	}

	use app/nombreModelo;#importar el modelo en la hoja de código
	$consulta=NombreTabla::get();#

	$consulta=NombreTabla::orderBy('nombreCampo','DESC')->get();# para ordenar los registros!
	
	

