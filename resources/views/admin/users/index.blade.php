@extends('layouts.stisla')

@section('title', 'Usuarios')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Usuarios</h1>
    <div class="section-header-button ml-auto">
      <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
    </div>
  </div>

  <div class="section-body">
    @if (session('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: {!! json_encode(session('success')) !!},
          showConfirmButton: false,
          timer: 1500
        });
      </script>
    @endif

    <div class="card">
      <div class="card-header">
        <h4>Lista de Usuarios</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Creado</th>
              <th>Rol</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>{{ $user->role->nombre ?? '-' }}</td>
                <td>
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" id="delete-user-{{ $user->id }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmUserDelete({{ $user->id }})"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  function confirmUserDelete(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Este usuario será eliminado permanentemente.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-user-' + id).submit();
      }
    });
  }
</script>
@endsection
