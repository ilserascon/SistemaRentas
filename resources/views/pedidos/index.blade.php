@extends('layouts.stisla')

@section('title', 'Pedidos')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>pedidos</h1>
    <div class="section-header-button ml-auto">
      <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Nuevo Pedido</a>
    </div>
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('pedidos.index') }}" class="mb-4">
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
          <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Limpiar</a>
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
              <th>Fecha de entrega</th>
              <th>Fecha de entrega solicitada</th>
              <th>Fecha de devolucion</th>
              <th>Observacion</th>
              <th>Usuario</th>
              <th>Tipo Maquinaria</th>
              <th>Cliente</th>
              <th>Maquinaria</th>
              <th>Repartidor</th>
              <th>Estatus</th>
              <th>Creacion</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pedidos as $pedido)
              <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>{{ $pedido->fecha_en_entrega }}</td>
                <td>{{ $pedido->fecha_entrega_solicitada }}</td>
                <td>{{ $pedido->fecha_devolucion_solicitada }}</td>
                <td>{{ $pedido->observacion }}</td>
                <td>{{ $pedido->usuario->name ?? 'Sin usuario' }}</td>
                <td>{{ $pedido->tipoMaquinaria->descripcion ?? 'Sin tipo' }}</td>
                <td>{{ $pedido->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>{{ $pedido->maquinaria->nombre ?? 'Sin maquinaria' }}</td>
                <td>{{ $pedido->repartidor->nombre ?? 'Sin repartidor' }}</td>
                <td>{{ $pedido->estatusPedido->descripcion ?? 'Sin estatus' }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                <td>
                  <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('pedidos.delete', $pedido->id) }}" method="POST" class="d-inline me-2">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Cancelar este pedido?')">Cancelar</button>
                  </form>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asignarModal-{{ $pedido->id }}">
                    Asignar
                  </button>
                </td>
              </tr>
            @empty
              <tr><td colspan="14" class="text-center">No hay pedidos registrados.</td></tr>
            @endforelse
          </tbody>
        </table>

   
        

      </div>
    </div>
  </div>
</div>

@foreach ($pedidos as $pedido)
        <div class="modal fade" id="asignarModal-{{ $pedido->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $pedido->id }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-{{ $pedido->id }}">Asignar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>¿Estás seguro de que deseas asignar este pedido?</p>
                <p>Folio: {{ $pedido->folio }}</p>
                <p>Cliente: {{ $pedido->cliente->nombre ?? 'Sin cliente' }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <form action="{{ route('pedidos.asignar', $pedido->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-primary">Asignar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach

@endsection
