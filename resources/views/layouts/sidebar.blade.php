<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/home') }}"><img src="{{ asset('stisla/assets/img/Logo.jpeg') }}" alt="logo" width="50%"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/home') }}"></a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header" style="color: #3e2d96">Menú</li>

      @if (Auth::check() && Auth::user()->role && Auth::user()->role->nombre === 'Administrador')
        
        {{-- Usuarios --}}
        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-users"></i> <span>Usuarios</span>
          </a>
        </li>

        {{-- Almacenes --}}
        <li class="{{ request()->is('almacen*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('almacen.index') }}">
            <i class="fas fa-warehouse"></i> <span>Almacenes</span>
          </a>
        </li>

        {{-- Clientes --}}
        <li class="{{ request()->is('clientes*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('clientes.index') }}">
            <i class="fas fa-user-tie"></i> <span>Clientes</span>
          </a>
        </li>

        {{-- Repartidores --}}
        <li class="{{ request()->is('repartidores*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('repartidores.index') }}">
            <i class="fas fa-motorcycle"></i> <span>Repartidores</span>
          </a>
        </li>

        {{-- Maquinaria (Nuevo módulo) --}}
        <li class="{{ request()->is('maquinaria*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('maquinaria.index') }}">
            <i class="fas fa-cogs"></i> <span>Maquinaria</span>
          </a>
        </li>
        {{-- Pedido (Nuevo módulo) --}}
        <li class="{{ request()->is('pedidos*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('pedidos.index') }}">
            <i class="fas fa-warehouse"></i> <span>Pedidos</span>
          </a>
          </li>

          {{-- fallas (Nuevo módulo) --}}
        <li class="{{ request()->is('fallas*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('fallas.index') }}">
            <i class="fas fa-warehouse"></i> <span>fallas</span>
          </a>
          </li>



      @elseif (Auth::check() && Auth::user()->role && Auth::user()->role->nombre === 'Estandar')
        <li class="{{ request()->is('clientes*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('clientes.index') }}">
            <i class="fas fa-user-tie"></i> <span>Clientes</span>
          </a>
        </li>
      @endif
      
    </ul>
  </aside>
</div>

