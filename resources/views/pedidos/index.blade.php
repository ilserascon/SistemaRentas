@extends('layouts.stisla')

@section('title', 'Pedidos')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Pedidos</h1>
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
              <th>Usuario</th>
              <th>Cliente</th>
              <th>Repartidor</th>
              <th>Tipo Maquinaria</th>
              <th>Maquinaria</th>
              <th>Ubicacion</th>
              <th>Observacion</th>
              <th>Fecha de entrega</th>
              <th>Fecha de entrega solicitada</th>
              <th>Fecha de devolución solicitada</th>
              <th>Estatus</th>
              <th>Creación</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pedidos as $pedido)
              <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>{{ $pedido->usuario->name ?? 'Sin usuario' }}</td>
                <td>{{ $pedido->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>{{ $pedido->repartidor->nombre ?? 'Sin repartidor' }}</td>
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
                <td>
                  <button type="button" class="btn btn-primary btn-sm me-2 mb-2" data-toggle="modal" data-target="#asignarModal-{{ $pedido->id }}">
                    Asignar
                  </button>

                  <!-- Botón para abrir el modal de entregar -->
                  <button type="button" class="btn btn-success btn-sm me-2 mb-2" data-toggle="modal" data-target="#entregarModal-{{ $pedido->id }}">
                    Entregar
                  </button>

                  @if($pedido->id_maquinaria && 
                      isset($pedido->maquinaria) && 
                      $pedido->maquinaria->id_estatus_maquinaria == 1)
                    <button type="button" class="btn btn-warning btn-sm mb-2" data-toggle="modal" data-target="#fallaModal-{{ $pedido->id }}">
                      Falla
                    </button>
                  @endif

                  <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#cancelarModal-{{ $pedido->id }}">
                    Cancelar
                  </button>
                </td>
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

{{-- Modales para cada pedido --}}
@foreach ($pedidos as $pedido)
<!-- Modal Asignar -->
<div class="modal fade" id="asignarModal-{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="asignarModalLabel-{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asignarModalLabel-{{ $pedido->id }}">Asignar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Folio:</strong> {{ $pedido->folio }}</p>
        <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre ?? 'Sin cliente' }}</p>
        <p><strong>Tipo de Maquinaria:</strong> {{ $pedido->tipoMaquinaria->descripcion ?? 'Sin tipo' }}</p>
        <p><strong>Ubicación:</strong>
          @if ($pedido->ubicacion_url)
            <a href="{{ $pedido->ubicacion_url }}" target="_blank">Ver en Google Maps</a>
          @else
            No se registró ubicación
          @endif
        </p>

        <form action="{{ route('pedidos.asignar', $pedido->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="id_repartidor-{{ $pedido->id }}">Repartidor</label>
            <select name="id_repartidor" id="id_repartidor-{{ $pedido->id }}" class="form-control" required>
              <option value="">Seleccione un repartidor</option>
              @foreach ($repartidores as $repartidor)
                <option value="{{ $repartidor->id }}">{{ $repartidor->nombre }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="id_maquinaria-{{ $pedido->id }}">Maquinaria</label>
            <select name="id_maquinaria" id="id_maquinaria-{{ $pedido->id }}" class="form-control" required>
              <option value="">Seleccione una maquinaria</option>
              @foreach ($maquinarias->where('id_tipo_maquinaria', $pedido->id_tipo_maquinaria)->whereNotIn('id', $maquinariasEnRenta) as $maquinaria)
                <option value="{{ $maquinaria->id }}">{{ $maquinaria->nombre }}</option>
              @endforeach
            </select>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Asignar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cancelar -->
<div class="modal fade" id="cancelarModal-{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelarModalLabel-{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pedidos.delete', $pedido->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="cancelarModalLabel-{{ $pedido->id }}">Confirmar cancelación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¿Estás seguro que deseas cancelar el pedido con folio <strong>{{ $pedido->folio }}</strong>? 
          <p><strong>Por favor, agrega una observación:</strong></p>
          <div class="form-group">
            <textarea name="observacion" class="form-control" placeholder="Escribe una observación..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Sí, Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="entregarModal-{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="entregarModalLabel-{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pedidos.entregar', $pedido->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="entregarModalLabel-{{ $pedido->id }}">Confirmar entrega</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¿Estás seguro que deseas marcar el pedido con folio <strong>{{ $pedido->folio }}</strong> como <b>En entrega</b>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Sí, entregar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Falla -->
<div class="modal fade" id="fallaModal-{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="fallaModalLabel-{{ $pedido->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('fallas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_pedido" value="{{ $pedido->id }}">
        <input type="hidden" name="id_maquinaria" value="{{ $pedido->id_maquinaria }}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fallaModalLabel-{{ $pedido->id }}">Registrar Falla</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="id_tipo_falla-{{ $pedido->id }}">Tipo de Falla</label>
              <select name="id_tipo_falla" id="id_tipo_falla-{{ $pedido->id }}" class="form-control" required>
                <option value="">Seleccione un tipo</option>
                @foreach (\App\Models\TipoFalla::all() as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="id_clasificacion_falla-{{ $pedido->id }}">Clasificación</label>
              <select name="id_clasificacion_falla" id="id_clasificacion_falla-{{ $pedido->id }}" class="form-control" required>
                <option value="">Seleccione una clasificación</option>
                @foreach (\App\Models\ClasificacionFalla::all() as $clasificacion)
                  <option value="{{ $clasificacion->id }}">{{ $clasificacion->descripcion }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Registrar Falla</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach

@endsection

