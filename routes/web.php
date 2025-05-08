<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenController;  // Se agregó esta línea para importar el controlador AlmacenController
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos.index');
Route::get('pedidos/agregar',     [PedidosController::class, 'create'])->name('pedidos.create');
Route::post('pedidos/agregar',    [PedidosController::class, 'store'])->name('pedidos.store');
Route::get('pedidos/{id}',        [PedidosController::class, 'item'])->name('pedidos.item');
Route::get('pedidos/{id}/edit',   [PedidosController::class, 'edit'])->name('pedidos.edit');
Route::put('pedidos/{id}',        [PedidosController::class, 'update'])->name('pedidos.update'); 
Route::delete('pedidos/{id}/delete', [PedidosController::class, 'delete'])->name('pedidos.delete');
Route::post('/pedidos/{id}/asignar', [PedidosController::class, 'asignar'])->name('pedidos.asignar');

/*Route::middleware(['auth'])->group(function () {
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class);
});*/

Auth::routes();

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

// Se añadió esta línea para registrar las rutas del controlador "AlmacenController"
Route::resource('almacen', AlmacenController::class);  // Esta ruta se añadió para gestionar las operaciones del "almacen"


