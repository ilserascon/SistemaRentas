@extends('layouts.stisla')

@section('title', 'Nuevo Almacén')

@section('content')
<div class="section">
<div class="section-header">
    <h1>Nuevo Almacén</h1>
</div>

<div class="section-body">
    <div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('almacen.store') }}">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" required>
            @error('ubicacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('almacen.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
    </div>
</div>
</div>
@endsection
