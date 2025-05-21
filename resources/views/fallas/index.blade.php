@extends('layouts.stisla')

    @section('title', 'Listado de Fallas')

    @section('content')
    <div class="section">
    <div class="section-header">
        <h1>Fallas</h1>
    </div>
    <div class="section-body">
        <div class="card">
        <div class="card-header">
            <h4>Lista de Fallas</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Pedido</th>
                <th>Maquinaria</th>
                <th>Tipo de Falla</th>
                <th>Clasificación</th>
                <th>Fecha</th>
                <th>Acciones</th>
                </tr>
            </thead>
            {{-- ...tu tabla... --}}
            <tbody>
                @forelse ($fallas as $falla)
                    <tr>
                        <td>{{ $falla->id }}</td>
                        <td>{{ $falla->pedido->folio ?? '-' }}</td>
                        <td>{{ $falla->maquinaria->nombre ?? '-' }}</td>
                        <td>{{ $falla->tipoFalla->descripcion ?? '-' }}</td>
                        <td>{{ $falla->clasificacionFalla->descripcion ?? '-' }}</td>
                        <td>{{ $falla->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($falla->maquinaria->id_estatus_maquinaria == 2)
                                <button type="button" class="btn btn-success btn-sm me-2 mb-2" data-toggle="modal" data-target="#MantenimientoModal-{{ $falla->id }}">
                                    mantenimiento
                                </button>
                            @else
                                <span class="badge badge-secondary">En mantenimiento</span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay fallas disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

{{-- Modales para cada falla --}}
@foreach ($fallas as $falla)
    <div class="modal fade" id="MantenimientoModal-{{ $falla->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $falla->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('fallas.Mantenimiento', $falla->maquinaria->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-{{ $falla->id }}">Enviar a Mantenimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro que deseas enviar la maquinaria <strong>{{ $falla->maquinaria->nombre ?? '-' }}</strong> a mantenimiento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Sí, enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
    @extends('layouts.stisla')

    @section('title', 'Listado de Fallas')

    @section('content')
    <div class="section">
    <div class="section-header">
        <h1>Fallas</h1>
    </div>
    <div class="section-body">
        <div class="card">
        <div class="card-header">
            <h4>Lista de Fallas</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Pedido</th>
                <th>Maquinaria</th>
                <th>Tipo de Falla</th>
                <th>Clasificación</th>
                <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fallas as $falla)
                <tr>
                    <td>{{ $falla->id }}</td>
                    <td>{{ $falla->pedido->folio ?? '-' }}</td>
                    <td>{{ $falla->maquinaria->nombre ?? '-' }}</td>
                    <td>{{ $falla->tipoFalla->descripcion ?? '-' }}</td>
                    <td>{{ $falla->clasificacionFalla->descripcion ?? '-' }}</td>
                    <td>{{ $falla->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
    @endsection