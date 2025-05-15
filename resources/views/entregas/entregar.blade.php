@extends('layouts.stisla')

@section('title', 'Entregar Pedido')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Entregar Pedido</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Formulario de Entrega</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('entregas.entregar', $pedido->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" name="foto" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="firma">Firma</label>
            <input type="text" name="firma" class="form-control" placeholder="Firma del cliente" required>
          </div>
          <button type="submit" class="btn btn-success">Entregar</button>
          <a href="{{ route('entregas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection