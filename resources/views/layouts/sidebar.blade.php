<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/home') }}">Logo</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/home') }}"></a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Menú</li>

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

      @endif
    </ul>
  </aside>
</div>
