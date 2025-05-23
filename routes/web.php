<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RecibidosController;
use App\Http\Controllers\EntregasController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\FallasController;
use App\Http\Controllers\MecanicosController;
use Illuminate\Support\Facades\Auth;

// Redireccionar raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Ruta home tras login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas clientes (CRUD manual)
Route::middleware('auth')->group(function () {
    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('clientes/agregar', [ClientesController::class, 'create'])->name('clientes.create');
    Route::post('clientes/agregar', [ClientesController::class, 'store'])->name('clientes.store');
    Route::get('clientes/{id}', [ClientesController::class, 'item'])->name('clientes.item');
    Route::get('clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit');
    Route::put('clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('clientes/{id}/delete', [ClientesController::class, 'delete'])->name('clientes.delete');
});

// Autenticación
Auth::routes();

// Rutas con middleware admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

// Rutas para almacén, repartidores y maquinaria (CRUD con resource)
Route::middleware('auth')->group(function () {
    Route::resource('almacen', AlmacenController::class);
    Route::resource('repartidores', RepartidorController::class);
Route::get('/repartidores/{id}', [App\Http\Controllers\RepartidorController::class, 'show'])->name('repartidores.show');
    Route::resource('maquinaria', MaquinariaController::class);

Route::resource('mantenimiento', MantenimientoController::class);
Route::post('/mantenimiento/terminar/{id}', [MantenimientoController::class, 'terminar'])->name('mantenimiento.terminar');

Route::resource('fallas', App\Http\Controllers\FallasController::class);
Route::post('/fallas/enviar-mantenimiento/{id}', [FallasController::class, 'Mantenimiento'])->name('fallas.Mantenimiento');

    // Rutas pedidos
    Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/agregar', [PedidosController::class, 'create'])->name('pedidos.create');
    Route::post('pedidos/agregar', [PedidosController::class, 'store'])->name('pedidos.store');
    Route::get('pedidos/{id}', [PedidosController::class, 'item'])->name('pedidos.item');
    Route::get('pedidos/{id}/edit', [PedidosController::class, 'edit'])->name('pedidos.edit');
    Route::put('pedidos/{id}', [PedidosController::class, 'update'])->name('pedidos.update');
    Route::delete('pedidos/{id}/delete', [PedidosController::class, 'delete'])->name('pedidos.delete');
    Route::post('/pedidos/{id}/asignar', [PedidosController::class, 'asignar'])->name('pedidos.asignar');
    Route::post('/pedidos/{id}/entregar', [PedidosController::class, 'entregar'])->name('pedidos.entregar');
});

// Rutas para recibidos
Route::middleware('auth')->group(function () {
    Route::get('/recibidos', [RecibidosController::class, 'index'])->name('recibidos.index');
    Route::get('/recibidos/{id}', [RecibidosController::class, 'show'])->name('recibidos.show');
    Route::post('/recibidos/{id}/recibir', [RecibidosController::class, 'recibir'])->name('recibidos.recibir');
    Route::post('/recibidos/{id}/cancelar', [RecibidosController::class, 'cancelar'])->name('recibidos.cancelar');
});

// Rutas para entregas
Route::middleware('auth')->group(function () {
    Route::get('/entregas', [EntregasController::class, 'index'])->name('entregas.index');
    Route::get('/entregas/{id}/entregar', [EntregasController::class, 'showEntregar'])->name('entregas.showEntregar');
    Route::post('/entregas/{id}/entregar', [EntregasController::class, 'entregar'])->name('entregas.entregar');
    Route::post('/entregas/{id}/cancelar', [EntregasController::class, 'cancelar'])->name('entregas.cancelar');
});
// Rutas para mecánicos
Route::resource('mecanicos', MecanicosController::class);