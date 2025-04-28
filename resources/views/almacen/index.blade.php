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
    <div class="alert alert-success">{{ session('success') }}</div>
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
                <form action="{{ route('almacen.destroy', $almacen) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar almacén?')"><i class="fas fa-trash"></i></button>
                </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No hay almacenes registrados.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
    </div>
</div>
</div>
@endsection
