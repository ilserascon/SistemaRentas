@extends('layouts.stisla')

@section('title', 'Pedidos')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Pedidos asignados</h1>
    <div class="section-header-button ml-auto">
            <a href="{{ route('repartidores.index') }}" class="btn btn-primary">Volver a repartidores</a>
        </div>
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('repartidores.show', $repartidor->id) }}" class="mb-4">
      <div class="row">
        <div class="col-md-4">
          <select name="estatus" class="form-control">
            <option value="">-- Filtrar por estatus --</option>
            @foreach ($estatusPedidos as $estatus)
              <option value="{{ $estatus->id }}" {{ request('estatus') == $estatus->id ? 'selected' : '' }}>
                {{ $estatus->descripcion }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">Filtrar</button>
          <a href="{{ route('repartidores.show', $repartidor->id) }}" class="btn btn-secondary">Limpiar</a>
        </div>
      </div>
    </form>

    <div class="card">
      <div class="card-header">
        <h4>Lista de pedidos</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Id</th>
              <th>Folio</th>
              <th>Usuario</th>
              <th>Cliente</th>
            {{-- <th>Repartidor</th> --}}
              <th>Tipo Maquinaria</th>
              <th>Maquinaria</th>
              <th>Ubicacion</th>
              <th>Observacion</th>
              <th>Fecha de entrega</th>
              <th>Fecha de entrega solicitada</th>
              <th>Fecha de devolucion solicitada</th>
              <th>Estatus</th>
              <th>Creacion</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pedidos as $pedido)
              <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>{{ $pedido->usuario->name ?? 'Sin usuario' }}</td>
                <td>{{ $pedido->cliente->nombre ?? 'Sin cliente' }}</td>
                {{-- <td>{{ $pedido->repartidor->nombre ?? 'Sin repartidor' }}</td> --}}
                <td>{{ $pedido->tipoMaquinaria->descripcion ?? 'Sin tipo' }}</td>
                <td>{{ $pedido->maquinaria->nombre ?? 'Sin maquinaria' }}</td>
                <td>
                  @if ($pedido->ubicacion_url)
                    <a href="{{ $pedido->ubicacion_url }}" target="_blank">Ver mapa</a>
                  @else
                    -
                  @endif
                </td>
                <td>{{ $pedido->observacion ?? 'Sin observaciones'}}</td>
                <td>{{ $pedido->fecha_en_entrega ?? 'no asignada'}}</td>
                <td>{{ $pedido->fecha_entrega_solicitada }}</td>
                <td>{{ $pedido->fecha_devolucion_solicitada }}</td>
                <td>{{ $pedido->estatusPedido->descripcion ?? 'Sin estatus' }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
              </tr>
            @empty
              <tr><td colspan="14" class="text-center">No hay pedidos registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $pedidos->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
