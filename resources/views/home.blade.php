@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')
   @if(Route::is('home'))
    <div class="content">
        <div class="row">
            <div class="col-md-12 pl-1 pr-1">
                <div class="bg-white card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Lista de pendientes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dt-mant-table">
                                <thead>
                                    <tr>
                                        <th>Tarea</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($MensajeAjuste))
                                    <tr>
                                        <td>
                                            {{$MensajeAjuste}}
                                        </td>
                                        <td>
                                            <h5>
                                                <span class="badge badge-danger">
                                                    Ajuste pendiente
                                                </span>
                                            </h5>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="{{route('ajustes.automatico1')}}"> Realiazar Ajuste</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif

                                @forelse($listaPending as $pendiente)
                                    <tr>
                                        <td>{{$pendiente->fromUserN->name}} ha
                                            <b>{{$pendiente->actionDoneN->nombre}}</b>. Requiere que tome acción. ({{$pendiente->date_start->diffForHumans()}})
                                        </td>
                                        <td>
                                            <h5><span class="badge
										@if($pendiente->statusN->nombre=='Pendiente de aprobación'or'Modificado')
												badge-warning
										@elseif($pendiente->statusN->nombre=='Aprobado')
											    badge-success
										@elseif($pendiente->statusN->nombre=='Abortado'or'Rechazado')
 												badge-danger
										@elseif($pendiente->statusN->nombre=='Aprobado automática')
												badge-secondary
										@endif
                                            	">{{$pendiente->statusN->nombre}}</span></h5>
                                        </td>
                                        <td>
                                            @if($pendiente->task_type==1) <!--1=Pedidos-->
                                            <div class="mb-1">
                                                <a type="button" class="btn btn-sm col-12 btn-primary"
                                                   href="{{route('pedido.show', $pendiente->id_task)}}"> Ver pedido</a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    No existen pendientes
                                    @endforelse
                                </tbody>
                                <tfoot>
</tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

        @include('errors.custom-message')

        @yield('index')


        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection
