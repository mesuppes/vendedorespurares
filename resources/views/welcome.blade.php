<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />

<!-- Page Title -->
<title>Purares Clientes</title>

<!-- Favicon and Touch Icons -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{asset('dashboard/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
   <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
          <img src="{{asset('dashboard/assets/img/Logo-NEGRO.png')}}" alt="{{Auth::user()->name ?? ""}}"/>
          </div>
          </a>
            <a class="navbar-brand"> </a>
           </a>
  <a class="navbar-brand" href="#" target="_blank">Clientes</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li> -->
    </ul>
      <ul class="navbar-nav ml-auto">
      @if (Route::has('login'))
          @auth
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/home') }}">Menu</a>\
            </li>
          @else
          <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
              </li>
          @endauth
      @endif
    </ul>
    </div>


  </div>
</nav>

<br><br>

<div class="container">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="jumbotron">
        <h4>Sitio de Clientes Purares</h4>
        <p class="lead">Este es el sitio de clientes de <b>Purares</b>. Su uso está pensado sólo para clientes y personal de la empresa.</p>
        <p>Si te interesa contactarte puedas enviar un mail <a href="#" target="_blank">aqui</a>, o volver a la tienda <a href="https://purares.com.ar" target="_blank">purares.com.ar</a></p>
        <p class="lead">Ud. está ingresando a una plataforma informática que es propiedad de Americastime S.A. y que contiene información de la empresa  protegida, confidencial y/o de secreto industrial,  cuyo uso o manipulación indebidos puede generar al usuario responsabilidad jurídica. Los datos ingresados por los usuarios generan movimientos productivos, contables y comerciales y, de acuerdo a ello, los usuarios deben ser diligentes en la incorporación de los mismos.</p>
        <br>
         @if (Route::has('login'))
          @auth
            <div class="d-flex justify-content-center">
              <a class="btn btn-dark" href="{{ url('/home') }}">Ir a la aplicación</a>
            </div>
          @else
            <div class="d-flex justify-content-center">
              <a class="btn btn-dark" href="{{ route('login') }}">Ingresar</a>
            </div>
          @endauth
      @endif

      </div>

    </div>
  </div>
</div>

</body>

<script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>

</html>
