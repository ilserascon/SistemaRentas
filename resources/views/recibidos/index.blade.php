@extends('layouts.stisla')

@section('title', 'Pedidos Recibidos')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Pedidos Recibidos</h1>
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header">
        <h4>Lista de Pedidos</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Folio</th>
              <th>Estatus</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pedidos as $pedido)
              <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>
                  @if ($pedido->id_estatus_pedido == 4)
                    En Renta
                  @elseif ($pedido->id_estatus_pedido == 5)
                    Terminado
                  @endif
                </td>
                <td>
                  @if ($pedido->id_estatus_pedido == 4)
                    <a href="{{ route('recibidos.show', $pedido->id) }}" class="btn btn-primary btn-sm">Recibir</a>
                  @else
                    <!-- No mostrar acciones para pedidos terminados -->
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No hay pedidos disponibles.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection