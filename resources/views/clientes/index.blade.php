@extends('layouts.stisla')

@section('title', 'Clientes')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Clientes</h1>
    <div class="section-header-button ml-auto">
      <a href="{{ route('clientes.create') }}" class="btn btn-primary">Nuevo Cliente</a>
    </div>
  </div>

  <div class="section-body">
    @if (session('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: '{{ session('success') }}',
          showConfirmButton: false,
          timer: 1500
        });
      </script>
    @endif

    <form method="GET" action="{{ route('clientes.index') }}" class="mb-4">
      <div class="row">
        <div class="col-md-4">
          <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-4">
          <input type="text" name="rfc" class="form-control" placeholder="Buscar por RFC" value="{{ request('rfc') }}">
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">Filtrar</button>
          <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
      </div>
    </form>
    
    <div class="card">
      <div class="card-header">
        <h4>Lista de Clientes</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>RFC</th>
              <th>Razon Social</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Direccion</th>
              <th>Codigo Postal</th>
              <th>Creado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($clientes as $cliente)
              <tr>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->rfc }}</td>
                <td>{{ $cliente->razon_social }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->codigo_postal }}</td>
                <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="d-flex align-items-center">
                      <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i>
                      </a>

                      <form action="{{ route('clientes.delete', $cliente->id) }}" method="POST" class="d-inline me-2" id="delete-form-{{ $cliente->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $cliente->id }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>

                      <a href="{{ route('clientes.pedidos', $cliente->id) }}" class="btn btn-info btn-sm me-2">
  <i class="fas fa-list"></i> Ver Pedidos
</a>

                      </a>
                    </div>

                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center">No hay clientes registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $clientes->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert Delete Confirmation Script -->
<script>
  function confirmDelete(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'No podrás recuperar este cliente una vez eliminado.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Enviar el formulario de eliminación si el usuario confirma
        document.getElementById('delete-form-' + id).submit();
      }
    });
  }
</script>

@endsection
