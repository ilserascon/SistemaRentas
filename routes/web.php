<?php

// Importamos los controladores necesarios
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\AlmacenController; 
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\FallasController;

// Ruta principal que redirige al login
Route::get('/', function () {
    return redirect('/login'); 
});

// Ruta a la página de inicio una vez logueado
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para gestión de clientes
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index'); // Mostrar todos los clientes
Route::get('clientes/agregar', [ClientesController::class, 'create'])->name('clientes.create'); // Formulario para agregar cliente
Route::post('clientes/agregar', [ClientesController::class, 'store'])->name('clientes.store'); // Guardar nuevo cliente
Route::get('clientes/{id}', [ClientesController::class, 'item'])->name('clientes.item'); // Ver un cliente específico
Route::get('clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit'); // Formulario para editar cliente
Route::put('clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update'); // Actualizar cliente
Route::delete('clientes/{id}/delete', [ClientesController::class, 'delete'])->name('clientes.delete'); // Eliminar cliente

// Rutas de autenticación (login, registro, etc.)
Auth::routes();

// Rutas protegidas por autenticación y rol de administrador
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class); // CRUD de usuarios solo para admin
});

// Rutas para almacén (CRUD automático)
Route::resource('almacen', AlmacenController::class);

// Rutas para repartidores (CRUD automático)
Route::resource('repartidores', RepartidorController::class);
Route::get('/repartidores/{id}', [App\Http\Controllers\RepartidorController::class, 'show'])->name('repartidores.show');

// Rutas para maquinaria (CRUD automático)
Route::resource('maquinaria', MaquinariaController::class);

Route::resource('mantenimiento', MantenimientoController::class);
Route::post('/mantenimiento/terminar/{id}', [MantenimientoController::class, 'terminar'])->name('mantenimiento.terminar');

Route::resource('fallas', App\Http\Controllers\FallasController::class);
Route::post('/fallas/enviar-mantenimiento/{id}', [FallasController::class, 'Mantenimiento'])->name('fallas.Mantenimiento');

// Rutas para gestión de pedidos
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
