@extends('layouts.stisla')

@section('title', 'Recibir Pedido')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Recibir Pedido #{{ $pedido->id }}</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Subir Firma y Foto</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('recibidos.recibir', $pedido->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="foto" class="form-label">Foto del Pedido</label>
            <input type="file" name="foto" id="foto" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="firma" class="form-label">Firma del Cliente</label>
            <input type="text" name="firma" id="firma" class="form-control" placeholder="Dibuja la firma aquí" required>
          </div>
          <button type="submit" class="btn btn-success">Guardar</button>
          <a href="{{ route('recibidos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection