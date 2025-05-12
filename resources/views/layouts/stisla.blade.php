<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Inicio')</title>

  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css') }}">

</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      @include('layouts.navbar') 
      @include('layouts.sidebar')

      <div class="main-content">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="{{ asset('stisla/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('stisla/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/js/stisla.js') }}"></script>
  <script src="{{ asset('stisla/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/js/scripts.js') }}"></script>

</body>
</html>

<!-- En el archivo layouts.stisla (en la sección <head>) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">

<!-- Al final del archivo antes de </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>

