{{-- filepath: c:\Proyectos\rentas\resources\views\mecanicos\create.blade.php --}}
@extends('layouts.stisla')

@section('title', 'Nuevo Mecánico')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Nuevo Mecánico</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('mecanicos.store') }}" method="POST">
          @csrf

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}" required>
            @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="celular">Celular</label>
            <input name="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular') }}" required>
            @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="{{ route('mecanicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection