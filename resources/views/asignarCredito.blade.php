@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Asignar crédito</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('vendedor.creditoStore')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{$vendedor}}
                                        <input type="hidden" class="form-control"  name="idVendedor"  placeholder="Vendedor" value="{{$vendedor->id_vendedor}}">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" placeholder="Vendedor" value="{{$vendedor->nombre}} {{$vendedor->apellidos}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <input type="number" min="0" step=0.01 class="form-control" name="monto" placeholder="Ingrese el monto">
                                    </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success">Asignar crédito
</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    </div>
                </div>
            </div>
               </div>
            </div>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


        <!-- include dashboard -->
        @include('errors.custom-message')

        @yield('index')

        <!-- @include('layouts.partials.dashboard')   -->
        <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
<script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>

<script type="text/javascript">

</script>



@endsection
