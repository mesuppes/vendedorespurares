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
                            <div>
                            
                                <h5 class="card-title">Stock de productos</h5>
                                </div>
                
                                <span class="float-right">
                                    <a  href="{{route('productos.movimiento')}}"
                                        class="btn btn-sm btn-danger ml-auto">Ver movimientos
                                    </a>
                                </span>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
                                <div class="card-header">
                                    <h5 class="card-title"></h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Lote</th>
                                                    <th>Unidades</th>
                                                    <th>Kg</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productos as $producto)
                                                @if(isset($producto->stock))
                                                        @php
                                                        $r=0
                                                        @endphp
                                                    @foreach($producto->stockLote as $lote)
                                                        @php
                                                        $z=$producto->stockLote->count()
                                                        @endphp
                                                    <tr>
                                                        @if($r==0)
                                                        <td rowspan="{{$z}}">
                                                           <b>{{$producto->nombre_comercial}}</b>
                                                        </td>
                                                        @endif
                                                        <td>
                                                            @if(isset($lote->lote_compra))
                                                                C-{{$lote->lote_compra}}
                                                            @else
                                                                P-{{$lote->lote_produccion}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$lote->stock_unidades}} u
                                                        </td>
                                                        <td>
                                                            {{$lote->stock_kg}} kg
                                                        </td>
                                        
                                                    </tr>
                                                        @php
                                                        $r=$r+1
                                                        @endphp
                                                    @endforeach
                                                    <tr class="success">
                                                        <td>
                                                            subtotal:
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                           <b>{{$producto->stock->stock_unidades}}</b> U
                                                        </td>
                                                        <td>
                                                           <b>{{$producto->stock->stock_kg}}</b> U
                                                        </td>
                                                    </tr>
                                                @else
                                                <tr>
                                                    <td>
                                                        {{$producto->nombre_comercial}}
                                                    </td>
                                                    <td></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>




</div>
</div>




