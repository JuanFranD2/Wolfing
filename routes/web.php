<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\OperUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

/**
 * This file defines all the routes for the application, including those for 
 * authentication, user profile management, tasks, fees, clients, and provinces.
 * The routes are grouped by middleware and responsibilities (guest, authenticated, etc.).
 */

// Redirigir la raíz directamente a la ruta de login
Route::redirect('/', '/login');

// Ruta Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de Middleware para Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Ruta métodos principales Usuarios
    Route::resource('operUsers', OperUserController::class)->parameters([
        'operUsers' => 'user',
    ]);

    // Ruta métodos principales tareas
    Route::resource('tasks', TaskController::class);

    // Ruta métodos principales clientes
    Route::resource('clients', ClientController::class);

    // Ruta métodos principales usuarios
    Route::resource('fees', FeeController::class);

    // Mostrar Tareas
    // Ruta para mostrar todas las tareas
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // Formulario Crear Tarea
    Route::get('/tasks/formCreate/Admin', [TaskController::class, 'create'])->name('tasks.formCreateAdmin');

    // Formulario Mpdificar Tarea
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.formEdit');

    // VerClientes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

    // Ver Cliente {ID}
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');

    // Ver Cuotas
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');

    // Formulario Crear Cuota Extraorninaria
    Route::get('/fees/create/ExtraordinaryFee', [FeeController::class, 'createExtraordinary'])->name('fees.createExtraordinaryFee');

    // Crear Cuota
    Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
});

// Grupo de Middleware para Oper
Route::middleware(['auth', 'oper'])->group(function () {

    Route::get('/tasksOper/{id}', [TaskController::class, 'show'])->name('tasks.showOper');

    // Ruta para mostrar el formulario de completar tarea (GET)
    Route::get('tasks/{task}/complete', [TaskController::class, 'showCompleteTask'])->name('tasks.showCompleteTask');

    // Ruta para completar tarea
    Route::put('/tasks/{id}/complete', [TaskController::class, 'completeTask'])->name('tasks.completeTask');

    // Ruta para mostrar todas las tareas
    Route::get('/tasksOper', [TaskController::class, 'index'])->name('tasksOper.index');
});

// Ruta para acceder a la creación de una nueva tarea para un cliente
Route::get('/tasks/create/client', [TaskController::class, 'createClient'])->name('tasks.create.client');

//Ruta para que el cliente cree una nueva tarea
Route::post('/tasks/store/client', [TaskController::class, 'storeClientTask'])->name('tasks.storeClientTask');

Route::get('/thanks-client', function () {
    return view('tasks.thanksClient');
})->name('tasks.thanks.client');

Route::resource('provinces', ProvinceController::class);

require __DIR__ . '/auth.php';
