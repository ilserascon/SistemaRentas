@extends('layouts.stisla')

@section('title', 'Editar Pedido')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Editar Pedido</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="folio">Folio</label>
            <input name="folio" class="form-control @error('folio') is-invalid @enderror" value="{{ old('folio', $pedido->folio) }}" required>
            @error('folio') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="fecha_en_entrega">Fecha en Entrega</label>
            <input type="datetime-local" name="fecha_en_entrega" class="form-control @error('fecha_en_entrega') is-invalid @enderror" value="{{ old('fecha_en_entrega', $pedido->fecha_en_entrega) }}" required>
            @error('fecha_en_entrega') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="fecha_entrega_solicitada">Fecha de Entrega Solicitada</label>
            <input type="datetime-local" name="fecha_entrega_solicitada" class="form-control @error('fecha_entrega_solicitada') is-invalid @enderror" value="{{ old('fecha_entrega_solicitada', $pedido->fecha_entrega_solicitada) }}" required>
            @error('fecha_entrega_solicitada') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="fecha_devolucion_solicitada">Fecha de Devolución Solicitada</label>
            <input type="datetime-local" name="fecha_devolucion_solicitada" class="form-control @error('fecha_devolucion_solicitada') is-invalid @enderror" value="{{ old('fecha_devolucion_solicitada', $pedido->fecha_devolucion_solicitada) }}" required>
            @error('fecha_devolucion_solicitada') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="observacion">Observación</label>
            <textarea name="observacion" class="form-control @error('observacion') is-invalid @enderror">{{ old('observacion', $pedido->observacion) }}</textarea>
            @error('observacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_usuario">Usuario</label>
            <select name="id_usuario" class="form-control @error('id_usuario') is-invalid @enderror" required>
              <option value="">Seleccione un usuario</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('id_usuario', $pedido->id_usuario) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
            @error('id_usuario') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_tipo_maquinaria">Tipo de maquinaria</label>
            <select name="id_tipo_maquinaria" class="form-control @error('id_tipo_maquinaria') is-invalid @enderror" required>
              <option value="">Seleccione el tipo de maquinaria</option>
              @foreach ($tipoMaquinarias as $tipoMaquinaria)
                <option value="{{ $tipoMaquinaria->id }}" {{ old('id_tipo_maquinaria', $pedido->id_tipo_maquinaria) == $tipoMaquinaria->id ? 'selected' : '' }}>{{ $tipoMaquinaria->descripcion }}</option>
              @endforeach
            </select>
            @error('id_tipo_maquinaria') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_cliente">Cliente</label>
            <select name="id_cliente" class="form-control @error('id_cliente') is-invalid @enderror" required>
              <option value="">Seleccione un cliente</option>
              @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('id_cliente', $pedido->id_cliente) == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
              @endforeach
            </select>
            @error('id_cliente') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_maquinaria">Maquinaria</label>
            <select name="id_maquinaria" class="form-control @error('id_maquinaria') is-invalid @enderror" required>
              <option value="">Seleccione una maquinaria</option>
              @foreach ($maquinarias as $maquinaria)
                <option value="{{ $maquinaria->id }}" {{ old('id_maquinaria', $pedido->id_maquinaria) == $maquinaria->id ? 'selected' : '' }}>{{ $maquinaria->nombre }}</option>
              @endforeach
            </select>
            @error('id_maquinaria') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_repartidor">Repartidor</label>
            <select name="id_repartidor" class="form-control @error('id_repartidor') is-invalid @enderror" required>
              <option value="">Seleccione un repartidor</option>
              @foreach ($repartidores as $repartidor)
                <option value="{{ $repartidor->id }}" {{ old('id_repartidor', $pedido->id_repartidor) == $repartidor->id ? 'selected' : '' }}>{{ $repartidor->nombre }}</option>
              @endforeach
            </select>
            @error('id_repartidor') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_estatus_pedido">Estatus del Pedido</label>
            <select name="id_estatus_pedido" class="form-control @error('id_estatus_pedido') is-invalid @enderror" required>
              <option value="">Seleccione un estatus</option>
              @foreach ($estatusPedidos as $estatus)
                <option value="{{ $estatus->id }}" {{ old('id_estatus_pedido', $pedido->id_estatus_pedido) == $estatus->id ? 'selected' : '' }}>{{ $estatus->descripcion }}</option>
              @endforeach
            </select>
            @error('id_estatus_pedido') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection