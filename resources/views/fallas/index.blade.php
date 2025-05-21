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