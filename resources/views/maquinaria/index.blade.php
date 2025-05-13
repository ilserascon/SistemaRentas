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
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('maquinaria.index') }}" class="mb-3">
            <div class="form-group">
                <input type="text" name="numero_serie" class="form-control" placeholder="Número de serie" value="{{ request('numero_serie') }}">
            </div>
            <div class="form-group">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
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
                            <th>Tipo de Maquinaria</th> <!-- Nueva columna -->
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
                            <td>{{ $maquinaria->tipoMaquinaria->descripcion ?? 'Sin tipo' }}</td> <!-- Mostrar tipo de maquinaria -->
                            <td>
                                <a href="{{ route('maquinaria.edit', $maquinaria->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('maquinaria.destroy', $maquinaria->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar maquinaria?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
