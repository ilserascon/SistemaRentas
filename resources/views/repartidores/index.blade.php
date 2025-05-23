@extends('layouts.stisla')

@section('title', 'Repartidores')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Listado de Repartidores</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('repartidores.create') }}" class="btn btn-primary">Nuevo Repartidor</a>
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

        <div class="card">
            <div class="card-header">
                <h4>Repartidores Registrados</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repartidores as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->nombre }}</td>
                            <td>{{ $r->telefono }}</td>
                            <td>{{ $r->email }}</td>
                            <td>
                                @if($r->borrado == 0)
                                    <a href="{{ route('repartidores.show', $r->id) }}" class="btn btn-primary btn-sm">Ver Pedidos</a>
                                    <a href="{{ route('repartidores.edit', $r->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('repartidores.destroy', $r->id) }}" method="POST" class="d-inline" id="delete-form-{{ $r->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $r->id }})"><i class="fas fa-trash"></i></button>
                                    </form>
                                @else
                                    <span class="text-muted">Eliminado</span>
                                    <form action="{{ route('repartidores.restore', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de restaurar este repartidor?')">
                                            <i class="fas fa-undo"></i> Restaurar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">No hay repartidores registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                {{ $repartidores->links() }}
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
            text: 'No podrás recuperar este repartidor una vez eliminado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
