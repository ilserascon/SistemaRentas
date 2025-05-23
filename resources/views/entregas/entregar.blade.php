@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Entregar Pedido #{{ $pedido->id }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('entregas.entregar', $pedido->id) }}" enctype="multipart/form-data" onsubmit="guardarFirma()">
                @csrf

                <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Tomar Foto:</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" capture="environment" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Firma:</label>
                    <div class="border rounded bg-light p-2 d-inline-block">
                        <canvas id="canvasFirma" width="300" height="150" style="background: #fff; border:1px solid #ced4da; border-radius: 4px;"></canvas>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFirma()">Limpiar Firma</button>
                    </div>
                    <input type="hidden" name="firma" id="firma">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Entregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let canvas = document.getElementById('canvasFirma');
let ctx = canvas.getContext('2d');
let dibujando = false;

canvas.addEventListener('mousedown', function(e) {
    dibujando = true;
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
});
canvas.addEventListener('mousemove', function(e) {
    if (dibujando) {
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
    }
});
canvas.addEventListener('mouseup', function(e) {
    dibujando = false;
});
canvas.addEventListener('mouseleave', function(e) {
    dibujando = false;
});

function limpiarFirma() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function guardarFirma() {
    let firmaInput = document.getElementById('firma');
    firmaInput.value = canvas.toDataURL();
}
</script>
@endsection