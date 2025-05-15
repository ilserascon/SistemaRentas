@extends('layouts.stisla')

@section('title', 'Editar Maquinaria')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Editar Maquinaria</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('maquinaria.update', $maquinaria->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $maquinaria->nombre) }}" required>
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero_serie">Número de Serie</label>
                        <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" value="{{ old('numero_serie', $maquinaria->numero_serie) }}" required>
                        @error('numero_serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo', $maquinaria->modelo) }}" required>
                        @error('modelo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control">{{ old('descripcion', $maquinaria->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="id_tipo_maquinaria">Tipo de Maquinaria</label>
                        <select name="id_tipo_maquinaria" class="form-control" required>
                            @foreach ($tipos_maquinaria as $tipo)
                                <option value="{{ $tipo->id }}" {{ $maquinaria->id_tipo_maquinaria == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_almacen">Almacén</label>
                        <select name="id_almacen" class="form-control" required>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ $maquinaria->id_almacen == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('maquinaria.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
