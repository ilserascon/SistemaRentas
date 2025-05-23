@extends('layouts.stisla')

@section('title', 'Maquinaria')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Listado de Maquinaria</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('maquinaria.create') }}" class="btn btn-primary">Nueva Maquinaria</a>
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

        <!-- Formulario de filtros en un solo renglón -->
        <form method="GET" action="{{ route('maquinaria.index') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <input type="text" name="numero_serie" class="form-control" placeholder="Número de serie" value="{{ request('numero_serie') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                    <a href="{{ route('maquinaria.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <h4>Maquinaria Registrada</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Número de Serie</th>
                            <th>Modelo</th>
                            <th>Descripción</th>
                            <th>Tipo de Maquinaria</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maquinarias as $maquinaria)
                        <tr>
                            <td>{{ $maquinaria->nombre }}</td>
                            <td>{{ $maquinaria->numero_serie }}</td>
                            <td>{{ $maquinaria->modelo }}</td>
                            <td>{{ $maquinaria->descripcion }}</td>
                            <td>{{ $maquinaria->tipoMaquinaria->descripcion ?? 'Sin tipo' }}</td>
                            <td>{{ $maquinaria->EstatusMaquinaria->descripcion ?? 'Sin tipo' }}</td>
                            <td>
                                <a href="{{ route('maquinaria.edit', $maquinaria->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('maquinaria.destroy', $maquinaria->id) }}" method="POST" class="d-inline" id="delete-form-{{ $maquinaria->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $maquinaria->id }})"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                {{ $maquinarias->links() }}
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
            text: 'No podrás recuperar esta maquinaria una vez eliminada.',
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
