<div class="sidebar" data-color="white" data-active-color="primary">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo bg-dark">



        <a href="#" class="simple-text logo-normal">
         Bienvenido, {{ Auth::user()->name }}<br>

          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">

        <li {{Route::is('home')? 'class=active':''}}>
          <a href="{{route('home')}}">
            <i class="nc-icon nc-bell-55"></i>
            <p>Pendientes</p>
          </a>
        </li>



    <!-- PEDIDOS -->

      <li {{Route::is('pedido.index') || Route::is('pedido.createRouter') || Route::is('pedido.create')? 'class=active':''}}>
      <a data-toggle="collapse" href="#Pedidos" aria-expanded="false" class="collapsed">
        <i class="nc-icon nc-bag-16"></i>
        <p>Pedidos</p>
        <b class="caret"></b>
      </a>
        <div class="collapse" id="Pedidos" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
        
            @can('Pedidos_Propios')
              <li {{Route::is('pedido.index')? 'class=active':''}}>
                  <a href="{{route('pedido.index')}}">
                    <i class="nc-icon  nc-align-left-2"></i>
                    <p>Mis pedidos</p>
                  </a>
              </li>

              <li {{Route::is('pedido.create')? 'class=active':''}}>
                  <a href="{{route('pedido.create')}}">
                    <i class="nc-icon nc-simple-add"></i>
                    <p>Agregar pedido</p>
                  </a>
              </li>
            @endcan
            
            @can('Clientes_Detalles')
               <li {{Route::is('pedido.index')? 'class=active':''}}>
                  <a href="{{route('pedido.index')}}">
                    <i class="nc-icon nc-align-left-2"></i>
                    <p>Ver todos los pedidos</p>
                  </a>
                </li>

              <li {{Route::is('pedido.createRouter')? 'class=active':''}}>
                <a href="{{route('pedido.createRouter')}}">
                  <i class="nc-icon nc-simple-add"></i>
                  <p>Agregar pedidos</p>
                </a>
              </li>
            @endcan       
          </ul>
        </div>

      
      <!-- PRODUCTOS -->

              @can('Productos_Gestionar')
      <li {{Route::is('productos.index') || Route::is('productos.create') || Route::is('productos.stock') ? 'class=active':''}}>
        <a data-toggle="collapse" href="#productos" aria-expanded="false" class="collapsed">
          <i class="nc-icon nc-app"></i>
          <p>Productos</p>
          <b class="caret"></b>
        </a>
          <div class="collapse" id="productos" aria-expanded="false" style="height: 0px;">
            <ul class="nav">
                <li {{Route::is('productos.create')? 'class=active':''}}>
                  <a href="{{route('productos.create')}}">
                    <i class="nc-icon nc-simple-add"></i>
                    <p>Agregar producto</p>
                  </a>
                </li>
                <li {{Route::is('productos.index')? 'class=active':''}}>
                  <a href="{{route('productos.index')}}">
                    <i class="nc-icon  nc-align-left-2"></i>
                    <p>Ver productos</p>
                  </a>
                </li>
                <li {{Route::is('productos.stock')? 'class=active':''}}>
                  <a href="{{route('productos.stock')}}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>Stock productos</p>
                  </a>
                </li>
          </ul>
        </div>
              @endcan

    <!-- PRECIOS -->
              @can('Precios_Ver')
                <li {{Route::is('precios.create')? 'class=active':''}}>
                  <a href="{{route('precios.create')}}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>Precios</p>
                  </a>
                </li>
              @endcan

   <!-- AJUSTE DE INVENTARIOS -->
    @can('Ajustestock_G')
      <li {{Route::is('ajustes.create') || Route::is('ajustes.index')? 'class=active':''}}>
      <a data-toggle="collapse" href="#ajusteInventario" aria-expanded="false" class="collapsed">
        <i class="nc-icon nc-layout-11"></i>
        <p>Ajustes de Inventario</p>
        <b class="caret"></b>
      </a>
        <div class="collapse" id="ajusteInventario" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
            <li {{Route::is('ajustes.create')? 'class=active':''}}>
                <a href="{{route('ajustes.create')}}">
                  <i class="nc-icon nc-simple-add"></i>
                  <p>Agregar ajuste</p>
                </a>
              </li>
              <li {{Route::is('ajustes.index')? 'class=active':''}}>
                <a href="{{route('ajustes.index')}}">
                  <i class="nc-icon nc-align-left-2"></i>
                  <p>Ver todos los ajustes</p>
                </a>
              </li>
            </ul>
          </div>
    @endcan
      <!-- CLIENTES -->

      <li {{Route::is('vendedores.create') || Route::is('vendedores.index')? 'class=active':''}}>

      <a data-toggle="collapse" href="#clientes" aria-expanded="false" class="collapsed">
        <i class="nc-icon nc-badge"></i>
        <p>Clientes</p>
        <b class="caret"></b>
      </a>
        <div class="collapse" id="clientes" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
            @can('Clientes_Detalles')
              <li {{Route::is('vendedores.create')? 'class=active':''}}>
                <a href="{{route('vendedores.create')}}">
                  <i class="nc-icon nc-simple-add"></i>
                  <p>Agregar cliente</p>
                </a>
              </li>
            @endcan
            @can('Clientes_VerTodos')
              <li {{Route::is('vendedores.index')? 'class=active':''}}>
                <a href="{{route('vendedores.index')}}">
                  <i class="nc-icon  nc-align-left-2"></i>
                  <p>Ver clientes</p>
                </a>
              </li>
            @endcan
          </ul>
        </div>

      <!-- COMPRAS -->

      @can('Compras_Gestionar')

        <li {{Route::is('compras.index') || Route::is('compras.create')? 'class=active':''}}>

          <a data-toggle="collapse" href="#compras" aria-expanded="false" class="collapsed">
            <i class="nc-icon nc-cart-simple"></i>
            <p>Compras</p>
            <b class="caret"></b>
          </a>

        <div class="collapse" id="compras" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
            <li {{Route::is('compras.create')? 'class=active':''}}>
              <a href="{{route('compras.create')}}">
                <i class="nc-icon nc-simple-add"></i>
                <p>Agregar compra</p>
              </a>
            </li>
            <li {{Route::is('compras.index')? 'class=active':''}}>
              <a href="{{route('compras.index')}}">
                <i class="nc-icon  nc-align-left-2"></i>
                <p>Ver compras</p>
              </a>
            </li>
          </ul>
        </div>

      @endcan

      <!-- REPORTE -->
      @can('Reportes_Ver')

        <li {{Route::is('reporte.create') || Route::is('reporte.ventas') ? 'class=active':''}}>

          <a data-toggle="collapse" href="#reportes" aria-expanded="false" class="collapsed">
            <i class="nc-icon nc-chart-bar-32"></i>
            <p>Reportes</p>
            <b class="caret"></b>
          </a>

        <div class="collapse" id="reportes" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
            <li {{Route::is('reporte.create') || Route::is('reporte.ventas')? 'class=active':''}}>
              <a href="{{route('reporte.create')}}">
                <i class="nc-icon nc-delivery-fast"></i>
                <p>Ventas</p>
              </a>
            </li>
          </ul>
        </div>
      @endcan

      <!-- GESTIONAR PERMISOS Y USUARIOS-->
      @can('Usuarios_Gestionar')
        <li {{Route::is('permissions.index')||Route::is('permissions.create')||Route::is('permissions.edit')||Route::is('roles.index')||Route::is('roles.create')||Route::is('roles.edit')||Route::is('users.index')||Route::is('users.create')||Route::is('users.edit')? 'class=active':''}}>
          <a data-toggle="collapse" href="#users" aria-expanded="false" class="collapsed">
              <i class="nc-icon nc-badge"></i>
              <p>Cambiar permisos y roles</p>
              <b class="caret"></b>
          </a>
        <div class="collapse" id="users" aria-expanded="false" style="height: 0px;">
          <ul class="nav">
          <li {{Route::is('permissions.index')||Route::is('permissions.create')||Route::is('permissions.edit')? 'class=active':''}}>
              <a href="{{route('permissions.index')}}">
              <i class="nc-icon nc-single-02"></i>
                  <p>Permisos</p>
              </a>
            </li>
            <li {{Route::is('roles.index')||Route::is('roles.create')||Route::is('roles.edit')? 'class=active':''}}>
              <a href="{{route('roles.index')}}">
              <i class="nc-icon nc-single-02"></i>
                  <p>Roles</p>
              </a>
            </li>
            <li {{Route::is('users.index')||Route::is('users.create')||Route::is('users.edit')? 'class=active':''}}>
              <a href="{{route('users.index')}}">
              <i class="nc-icon nc-single-02"></i>
                  <p>Usuarios</p>
              </a>
            </li>
          </ul>
        </div>
      @endcan


      @role('Cliente')
      <li {{Route::is('vendedor.vendedor.edit')? 'class=active':''}}>
        <a href="{{ route('vendedor.edit',Auth::user()->vendedor->id_vendedor) }}">
          <i class="nc-icon nc-circle-10"></i>
          <p>Mi perfil</p>
        </a>
      </li>
      @endrole

        <li {{Route::is('password.request')? 'class=active':''}}>
         <a href="{{ route('password.request') }}">
            <i class="nc-icon nc-key-25"></i>
            <p>Cambiar contraseña</p>
            </a>
        </ul>
      </div>
</div>

