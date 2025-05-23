@extends('layouts.stisla')

@section('title', 'Recibir Pedido')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Recibir Pedido #{{ $pedido->id }}</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Subir Firma y Foto</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('recibidos.recibir', $pedido->id) }}" enctype="multipart/form-data" onsubmit="guardarFirma()">
          @csrf

          <div class="form-group">
            <label for="foto">Tomar Foto</label>
            <div id="camera-container" class="mb-2">
              <video id="video" width="320" height="240" autoplay style="border:1px solid #ced4da; border-radius:4px;"></video>
              <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
            </div>
            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="tomarFoto()">Capturar Foto</button>
            <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="reiniciarCamara()">Reiniciar Cámara</button>
            <input type="hidden" name="foto" id="foto" required>
            <div id="foto-preview" class="mt-2"></div>
            @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="firma">Firma del Cliente</label>
            <div class="border rounded bg-light p-2 d-inline-block">
              <canvas id="canvasFirma" width="300" height="150" style="background: #fff; border:1px solid #ced4da; border-radius: 4px;"></canvas>
            </div>
            <div class="mt-2">
              <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFirma()">Limpiar Firma</button>
            </div>
            <input type="hidden" name="firma" id="firma" required>
            @error('firma') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn btn-success">Guardar</button>
          <a href="{{ route('recibidos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let fotoInput = document.getElementById('foto');
let fotoPreview = document.getElementById('foto-preview');
let stream = null;

// Iniciar cámara al cargar la página
async function iniciarCamara() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.play();
        canvas.style.display = 'none';
        video.style.display = 'block';
        fotoPreview.innerHTML = '';
        fotoInput.value = '';
    } catch (e) {
        fotoPreview.innerHTML = '<div class="alert alert-danger">No se pudo acceder a la cámara</div>';
    }
}

function tomarFoto() {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    let dataUrl = canvas.toDataURL('image/png');
    fotoInput.value = dataUrl;
    fotoPreview.innerHTML = '<img src="' + dataUrl + '" class="img-thumbnail" width="160">';
    canvas.style.display = 'block';
    video.style.display = 'none';
}

function reiniciarCamara() {
    iniciarCamara();
}

window.onload = iniciarCamara;

// --- Script de firma ---
let canvasFirma = document.getElementById('canvasFirma');
let ctx = canvasFirma.getContext('2d');
let dibujando = false;

canvasFirma.addEventListener('mousedown', function(e) {
    dibujando = true;
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
});
canvasFirma.addEventListener('mousemove', function(e) {
    if (dibujando) {
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
    }
});
canvasFirma.addEventListener('mouseup', function(e) {
    dibujando = false;
});
canvasFirma.addEventListener('mouseleave', function(e) {
    dibujando = false;
});

function limpiarFirma() {
    ctx.clearRect(0, 0, canvasFirma.width, canvasFirma.height);
}

function guardarFirma() {
    let firmaInput = document.getElementById('firma');
    firmaInput.value = canvasFirma.toDataURL();
}
</script>
@endsection