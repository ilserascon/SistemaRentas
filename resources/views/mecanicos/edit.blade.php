{{-- filepath: c:\Proyectos\rentas\resources\views\mecanicos\edit.blade.php --}}
@extends('layouts.stisla')

@section('title', 'Editar Mecánico')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Editar Mecánico</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('mecanicos.update', $mecanico->id) }}">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $mecanico->nombre) }}" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $mecanico->correo) }}" required>
            @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="celular">Celular</label>
            <input name="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular', $mecanico->celular) }}" required>
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