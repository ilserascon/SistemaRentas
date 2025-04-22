<?php

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

/*Route::middleware(['auth'])->group(function () {
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class);
});*/

Auth::routes();

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

// Se añadió esta línea para registrar las rutas del controlador "AlmacenController"
Route::resource('almacen', AlmacenController::class);  // Esta ruta se añadió para gestionar las operaciones del "almacen"