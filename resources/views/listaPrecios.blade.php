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
                    <div class="card-header">
                        <h5 class="card-title">Lista de precios</h5>
                    </div>
                    <div class="card-body">
                        <h3>Productos sin precio</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio por unidad</th>
                                        <th>Precio por kilo</th>
                                        <th>Valido desde</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosSinPrecio as $producto)
                                    <tr>
                                        <th>{{$producto->nombre_comercial ?? 'No hay datos'}}</th>
                                        <th>{{$producto->precio_kg  ?? 'No hay datos'}}</th>
                                        <td>{{$producto->precio_unidad  ?? 'No hay datos'}}</td>
                                        <th>{{$producto->fecha_desde  ?? 'No hay datos'}}</th>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="">Editar</a>
                                            </div>
                                        </td>
                                         <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="">Ver Precio futuro</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                     <div class="card-body">
                        <h3>Productos</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio por unidad</th>
                                        <th>Precio por kilo</th>
                                        <th>Valido desde</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listaPrecios as $producto)
                                    <tr>
                                        <th>{{$producto->producto->nombre_comercial ?? 'No hay datos'}}</th>
                                        <th>{{$producto->precio_kg  ?? 'No hay datos'}}</th>
                                        <td>{{$producto->precio_unidad  ?? 'No hay datos'}}</td>
                                        <th>{{$producto->fecha_desde  ?? 'No hay datos'}}</th>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="">Editar</a>
                                            </div>
                                        </td>
                                         <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="">Ver Precio futuro</a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
	        </div>
	    </div>
	</div>
</div>
</div>



