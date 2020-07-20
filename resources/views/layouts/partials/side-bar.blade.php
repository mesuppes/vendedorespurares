<div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          <div class="logo-image-small">
          <img src="{{url('storage/profile-pic')}}/{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}"/>
          </div>
        </a>
        <a href="#" class="simple-text logo-normal">
          {{ Auth::user()->name }}<br>
          {{Auth::user()->email}}
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
      
      @role('admin')
        <li {{Route::is('home')? 'class=active':''}}>
          <a href="{{route('home')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Dashboard</p>
          </a>
        </li>
      @endrole

      @can('Usuarios_Gestionar')
      <li {{Route::is('permissions.index')||Route::is('permissions.create')||Route::is('permissions.edit')||Route::is('roles.index')||Route::is('roles.create')||Route::is('roles.edit')||Route::is('users.index')||Route::is('users.create')||Route::is('users.edit')? 'class=active':''}}>
          <a data-toggle="collapse" href="#users" aria-expanded="false" class="collapsed">
              <i class="nc-icon nc-bank"></i>
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
  

      @can('Pedidos_Propios')
        <li {{Route::is('pedido.index')? 'class=active':''}}>
            <a href="{{route('pedido.index')}}">
              <i class="nc-icon nc-bank"></i>
              <p>Mis pedidos</p>
            </a>
        </li>

        <li {{Route::is('pedido.create')? 'class=active':''}}>
            <a href="{{route('pedido.create')}}">
              <i class="nc-icon nc-bank"></i>
              <p>Agregar pedido</p>
            </a>
        </li>
      @endcan
      
      @can('Clientes_Detalles')  
         <li {{Route::is('pedido.index')? 'class=active':''}}>
            <a href="{{route('pedido.index')}}">
              <i class="nc-icon nc-bank"></i>
              <p>Ver todos los pedidos</p>
            </a>
          </li>
        </li>

        <li {{Route::is('pedido.createRouter')? 'class=active':''}}>
          <a href="{{route('pedido.createRouter')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Agregar pedidos</p>
          </a>
        </li>
      @endcan

      @can('Productos_Gestionar')  
        <li {{Route::is('productos.index')? 'class=active':''}}>
          <a href="{{route('productos.index')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Ver productos</p>
          </a>
        </li>
        <li {{Route::is('productos.create')? 'class=active':''}}>
          <a href="{{route('productos.create')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Agregar producto</p>
          </a>
        </li>
      @endcan
      
      @can('Precios_Ver')
        <li {{Route::is('precios.create')? 'class=active':''}}>
          <a href="{{route('precios.create')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Ver precios</p>
          </a>
        </li>
      @endcan

      @can('Clientes_Detalles')  
        <li {{Route::is('vendedores.create')? 'class=active':''}}>
          <a href="{{route('vendedores.create')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Agregar vendedor</p>
          </a>
        </li>
      @endcan
      
      @can('Clientes_VerTodos') 
        <li {{Route::is('vendedores.index')? 'class=active':''}}>
          <a href="{{route('vendedores.index')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Ver clientes</p>
          </a>
        </li>
      @endcan
      
      @can('Compras_Gestionar')
        <li {{Route::is('compras.index')? 'class=active':''}}>
          <a href="{{route('compras.index')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Ver compras</p>
          </a>
        </li>
        <li {{Route::is('compras.create')? 'class=active':''}}>
          <a href="{{route('compras.create')}}">
            <i class="nc-icon nc-bank"></i>
            <p>Agregar compra</p>
          </a>
        </li>
      @endcan

      <li {{Route::is('profile.index')? 'class=active':''}}>
        <a href="{{ route('profile.index') }}">
          <i class="nc-icon nc-circle-10"></i>
          <p>Mi perfil</p>
        </a>
      </li>

        </ul>
      </div>
</div>
