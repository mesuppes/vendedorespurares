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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pendiente</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($listaPending as $pendiente)
                                    <tr>
                                        <td>{{$pendiente}}</td>
                                        <td>
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
