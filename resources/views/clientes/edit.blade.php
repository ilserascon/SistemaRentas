@extends('layouts.stisla')

@section('title', 'Editar Cliente')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Editar Cliente</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $cliente->nombre) }}" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="rfc">RFC</label>
            <input name="rfc" class="form-control @error('rfc') is-invalid @enderror"
                   value="{{ old('rfc', $cliente->rfc) }}" required>
            @error('rfc') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="razon_social">Razón Social</label>
            <input name="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                   value="{{ old('razon_social', $cliente->razon_social) }}" required>
            @error('razon_social') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                   value="{{ old('telefono', $cliente->telefono) }}" required>
            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $cliente->email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                   value="{{ old('direccion', $cliente->direccion) }}" required>
            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input name="codigo_postal" class="form-control @error('codigo_postal') is-invalid @enderror"
                   value="{{ old('codigo_postal', $cliente->codigo_postal) }}" required>
            @error('codigo_postal') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
