@extends('layouts.stisla')

@section('title', 'Entregas')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Mis Entregas</h1>
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header">
        <h4>Lista de Entregas</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Folio</th>
              <th>Estatus</th>
              <th>Botones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pedidos as $pedido)
              <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>{{ $pedido->estatus->descripcion ?? 'Sin Estatus' }}</td>
                <td>
                  @if ($pedido->id_estatus_pedido == 3)
                    <a href="{{ route('entregas.showEntregar', $pedido->id) }}" class="btn btn-success btn-sm">Entregar</a>
                    <form method="POST" action="{{ route('entregas.cancelar', $pedido->id) }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                    </form>
                  @elseif ($pedido->id_estatus_pedido == 6)
                    <!-- No mostrar botones si el pedido está cancelado -->
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No tienes entregas pendientes.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection