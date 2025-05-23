    @extends('layouts.stisla')

    @section('title', 'Pedidos de ' . $cliente->nombre)

    @section('content')
    <div class="section">
    <div class="section-header">
        <h1>Pedidos de {{ $cliente->nombre }}</h1>
        <div class="section-header-button ml-auto">
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="section-body">

        <form method="GET" action="{{ route('clientes.pedidos', $cliente->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
            <select name="estatus" class="form-control">
            <option value="">-- Filtrar por estatus --</option>
            <option value="solicitado" {{ request('estatus') == 'solicitado' ? 'selected' : '' }}>Solicitado</option>
            <option value="asignado" {{ request('estatus') == 'asignado' ? 'selected' : '' }}>Asignado</option>
            <option value="en entrega" {{ request('estatus') == 'en entrega' ? 'selected' : '' }}>En entrega</option>
            <option value="en renta" {{ request('estatus') == 'en renta' ? 'selected' : '' }}>En renta</option>
            <option value="terminado" {{ request('estatus') == 'terminado' ? 'selected' : '' }}>Terminado</option>
        </select>
            </div>
            <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('clientes.pedidos', $cliente->id) }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
        </form>

        <div class="card">
        <div class="card-header">
            <h4>Lista de Pedidos</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Folio</th>
                <th>Usuario</th>
                <th>Repartidor</th>
                <th>Tipo de Maquinaria</th>
                <th>Maquinaria</th>
                <th>Ubicacion</th>
                <th>Fecha de entrega</th>
                <th>Fecha de entrega solicitada</th>
                <th>Fecha de devolucion solicitada</th>
                <th>estatus</th>
                <th>creacion</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($pedidos as $pedido)
                <tr>
                    


                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->folio }}</td>
                <td>{{ $pedido->usuario->name ?? 'Sin usuario' }}</td>
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
                <td>{{ $pedido->fecha_en_entrega ? $pedido->fecha_en_entrega->format('d/m/Y H:i') : 'Sin fecha' }}</td>
                <td>{{ $pedido->fecha_entrega_solicitada }}</td>
                <td>{{ $pedido->fecha_devolucion_solicitada }}</td>
                <td>{{ $pedido->estatusPedido->descripcion ?? 'Sin estatus' }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                <td>




                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Este cliente no tiene pedidos.</td></tr>
                @endforelse
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
    @endsection
