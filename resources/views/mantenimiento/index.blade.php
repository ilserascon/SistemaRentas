{{-- resources/views/mantenimiento/index.blade.php --}}
@extends('layouts.stisla')

@section('title', 'Mantenimiento')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Mantenimientos</h1>
    {{-- <div class="section-header-button ml-auto">
      <a href="{{ route('mantenimiento.create') }}" class="btn btn-primary">Nuevo Mantenimiento</a>
    </div> --}}
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header">
        <h4>Lista de mantenimientos</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Maquinaria</th>
              <th>Tipo de falla</th>
              <th>Clasificación de falla</th>
              <th>Fecha de creación</th>
              <th>Fecha de actualización</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mantenimientos as $mantenimiento)
              <tr>
                <td>{{ $mantenimiento->id }}</td>
                <td>{{ $mantenimiento->falla->maquinaria->nombre ?? 'Sin maquinaria' }}</td>
                <td>{{ $mantenimiento->falla->tipoFalla->descripcion ?? 'Sin tipo' }}</td>
                <td>{{ $mantenimiento->falla->clasificacionFalla->descripcion ?? 'Sin clasificación' }}</td>
                <td>{{ $mantenimiento->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $mantenimiento->updated_at->format('d/m/Y H:i') }}</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#TerminarMantenimientoModal-{{ $mantenimiento->id }}">
                    Terminado
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">No hay mantenimientos registrados.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $mantenimientos->links() }}
        </div>

        {{-- Modales para cada mantenimiento --}}
       
      </div>
    </div>
  </div>
</div>
 @foreach ($mantenimientos as $mantenimiento)
          <div class="modal fade" id="TerminarMantenimientoModal-{{ $mantenimiento->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabelTerminar-{{ $mantenimiento->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form method="POST" action="{{ route('mantenimiento.terminar', $mantenimiento->falla->maquinaria->id) }}">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelTerminar-{{ $mantenimiento->id }}">Confirmar Terminado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ¿Estás seguro que deseas marcar la maquinaria <strong>{{ $mantenimiento->falla->maquinaria->nombre ?? '-' }}</strong> como terminada y disponible?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Sí, Terminar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
@endsection