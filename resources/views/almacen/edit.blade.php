@extends('layouts.stisla')

@section('title', 'Editar Almacén')

@section('content')
<div class="section">
<div class="section-header">
    <h1>Editar Almacén</h1>
</div>

<div class="section-body">
    <div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('almacen.update', $almacen) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $almacen->nombre) }}" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                value="{{ old('ubicacion', $almacen->ubicacion) }}" required>
            @error('ubicacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('almacen.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    </div>
</div>
</div>
@endsection
