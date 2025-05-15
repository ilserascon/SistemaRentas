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
              <th>Id_usuario</th>
              <th>Tipo Maquinaria</th>
              <th>Id_cliente</th>
              <th>Id_maquinaria</th>
              <th>Id_repartidor</th>
              <th>Id_estatus_pedido</th>
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
                <td>{{ $pedido->id_usuario }}</td>
                <td>{{ $pedido->id_tipo_maquinaria }}</td>
                <td>{{ $pedido->id_cliente }}</td>
                <td>{{ $pedido->id_maquinaria }}</td>
                <td>{{ $pedido->id_repartidor }}</td>
                <td>{{ $pedido->id_estatus_pedido}}</td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                <td>
                  <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('pedidos.delete', $pedido->id) }}" method="POST" class="d-inline me-2">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center">No hay pedidos registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
index