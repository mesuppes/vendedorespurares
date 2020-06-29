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
                                <div class="card-header">
                                    <h5 class="card-title">Datos del pedido</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <input type="text" class="form-control" disabled="" placeholder="Company" value="Nombre Vendedor 1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese la condición del pago" value="Efectivo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese la forma de entrega" value="Mañana macho">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos del flete</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese los datos del flete" value="Lo trae el Cacho">
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
                                                <tr>
                                                    <td>Salame Parrillero</td>
                                                    <td>$10000 / Unidad</td>
                                                    <td>
                                                        <div class="mb-1">
                                                            100 Unidades
</div>
                                                        <div class="mb-1">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                Editar
</button>
                                                        </div>
                                                    </td>
                                                    <td>$1000000</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2">Jamon</td>
                                                    <td><strike>$ 950 / kilo</strike> </td>
                                                    <td><strike>350 kilos</strike></td>
                                                    <td><strike>$ 332500</strike></td>
                                                </tr>
                                                <tr>
                                                    <td>$ 1000 / kilo</td>
                                                    <td>
                                                        <div class="mb-1">
                                                            332.5 kilos
</div>
                                                        <div class="mb-1">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                Editar
</button>
                                                        </div>
                                                    </td>
                                                    <td>$ 332500</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>2 productos</th>
                                                    <th colspan="2">TOTAL $ 1332500</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
</div>
</div>
                            </div>
</div>
</div>



