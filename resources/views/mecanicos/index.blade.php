@extends('layouts.stisla')

@section('title', 'Mecánicos')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Listado de Mecánicos</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('mecanicos.create') }}" class="btn btn-primary">Nuevo Mecánico</a>
        </div>
    </div>

    <div class="section-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="GET" action="{{ route('mecanicos.index') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
                </div>
                    <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                    <a href="{{ route('mecanicos.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <h4>Mecánicos Registrados</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mecanicos as $mecanico)
                        <tr>
                            <td>{{ $mecanico->nombre }}</td>
                            <td>{{ $mecanico->correo }}</td>
                            <td>{{ $mecanico->celular }}</td>
                            <td>
                                <a href="{{ route('mecanicos.edit', $mecanico->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('mecanicos.destroy', $mecanico->id) }}" method="POST" class="d-inline" id="delete-form-{{ $mecanico->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $mecanico->id }})"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay mecánicos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
          {{ $mecanicos->links() }}
        </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás recuperar este mecánico una vez eliminado.',
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