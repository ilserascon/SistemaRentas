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
      <div class="alert alert-success">{{ session('success') }}</div>
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
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarModal-{{ $user->id }}">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modales para cada usuario --}}
@foreach ($users as $user)
<div class="modal fade" id="eliminarModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel-{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarModalLabel-{{ $user->id }}">Confirmar eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar al usuario <strong>{{ $user->name }}</strong>?
      </div>
      <div class="modal-footer">
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
