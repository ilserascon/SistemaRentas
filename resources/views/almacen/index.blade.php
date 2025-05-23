@extends('layouts.stisla')

@section('title', 'Almacenes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Lista de Almacenes</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('almacen.create') }}" class="btn btn-primary">Nuevo Almacén</a>
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
                <h4>Almacenes Registrados</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($almacenes as $almacen)
                        <tr>
                            <td>{{ $almacen->id }}</td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->ubicacion }}</td>
                            <td>
                                <a href="{{ route('almacen.edit', $almacen) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('almacen.destroy', $almacen) }}" method="POST" class="d-inline" id="delete-form-{{ $almacen->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $almacen->id }})"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No hay almacenes registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                {{ $almacenes->links() }}
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
            text: 'No podrás recuperar este almacén una vez eliminado.',
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
