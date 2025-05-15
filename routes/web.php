<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\recibidosController;
use App\Http\Controllers\entregasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenController; 
use App\Http\Controllers\RepartidorController; 
use App\Http\Controllers\MaquinariaController; 
use App\Http\Controllers\PedidosController;


Route::get('/', function () {
    return redirect('/login'); 
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
Route::get('clientes/agregar',     [ClientesController::class, 'create'])->name('clientes.create');
Route::post('clientes/agregar',    [ClientesController::class, 'store'])->name('clientes.store');
Route::get('clientes/{id}',        [ClientesController::class, 'item'])->name('clientes.item');
Route::get('clientes/{id}/edit',   [ClientesController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{id}',        [ClientesController::class, 'update'])->name('clientes.update'); 
Route::delete('clientes/{id}/delete', [ClientesController::class, 'delete'])->name('clientes.delete');
Route::get('/recibidos', [recibidosController::class, 'index'])->name('recibidos.index');
Route::get('recibidos/recibir',     [recibidosController::class, 'recibir'])->name('recibidos.recibir');
Route::get('/entregas', [entregasController::class, 'index'])->name('entregas.index');
Route::get('/entregas/{id}/entregar', [EntregasController::class, 'show'])->name('entregas.show');
Route::post('/entregas/{id}/entregar', [EntregasController::class, 'entregar'])->name('entregas.entregar');
Route::get('/entregas/{id}/cancelar', [EntregasController::class, 'cancelarView'])->name('entregas.cancelar.view');
Route::post('/entregas/{id}/cancelar', [EntregasController::class, 'cancelar'])->name('entregas.cancelar');
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class);

Auth::routes();

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

// Se añadió esta línea para registrar las rutas del controlador "AlmacenController"
Route::resource('almacen', AlmacenController::class);  // Esta ruta se añadió para gestionar las operaciones del "almacen"
Route::get('/recibidos', [RecibidosController::class, 'index'])->name('recibidos.index');
Route::get('/recibidos/{id}', [RecibidosController::class, 'show'])->name('recibidos.show');
Route::post('/recibidos/{id}/recibir', [RecibidosController::class, 'recibir'])->name('recibidos.recibir');
Route::post('/recibidos/{id}/cancelar', [RecibidosController::class, 'cancelar'])->name('recibidos.cancelar');
Route::resource('repartidores', RepartidorController::class); // Esta ruta se añadió para gestionar las operaciones del "repartidor"
Route::get('/repartidores', [RepartidorController::class, 'index'])->name('repartidores.index');
Route::get('/repartidores/create', [RepartidorController::class, 'create'])->name('repartidores.create');
Route::post('/repartidores', [RepartidorController::class, 'store'])->name('repartidores.store');
Route::get('/repartidores/{id}/edit', [RepartidorController::class, 'edit'])->name('repartidores.edit');
Route::put('/repartidores/{id}', [RepartidorController::class, 'update'])->name('repartidores.update');
Route::delete('/repartidores/{id}/delete', [RepartidorController::class, 'delete'])->name('repartidores.delete');
Route::get('/repartidores/{id}', [RepartidorController::class, 'show'])->name('repartidores.show');
Route::post('/repartidores/{id}/cancelar', [RepartidorController::class, 'cancelar'])->name('repartidores.cancelar');
Route::resource('maquinaria', MaquinariaController::class);
Route::middleware(['auth'])->group(function () {
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
Route::get('/recibidos', [RecibidosController::class, 'index'])->name('recibidos.index');
Route::get('/recibidos/{id}', [RecibidosController::class, 'show'])->name('recibidos.show');
Route::post('/recibidos/{id}/recibir', [RecibidosController::class, 'recibir'])->name('recibidos.recibir');
Route::post('/recibidos/{id}/cancelar', [RecibidosController::class, 'cancelar'])->name('recibidos.cancelar');
Route::middleware(['auth'])->group(function () {
    Route::get('/entregas', [EntregasController::class, 'index'])->name('entregas.index');
    Route::get('/entregas/{id}/entregar', [EntregasController::class, 'showEntregar'])->name('entregas.showEntregar');
    Route::post('/entregas/{id}/entregar', [EntregasController::class, 'entregar'])->name('entregas.entregar');
    Route::post('/entregas/{id}/cancelar', [EntregasController::class, 'cancelar'])->name('entregas.cancelar');
});