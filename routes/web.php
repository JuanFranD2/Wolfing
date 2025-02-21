<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\OperUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});
*/

// Redirigir la raíz directamente a la ruta de login
Route::redirect('/', '/login')->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para mostrar el formulario de modificación de un usuario oper
    Route::get('/users/{user}/edit', [OperUserController::class, 'edit'])->name('operUsers.edit');

    // Ruta para modificar el usuario oper
    Route::put('/users/{user}', [OperUserController::class, 'update'])->name('operUsers.update');

    // Ruta para mostrar todas las cuotas
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');

    Route::get('/fees/create-extraordinary', [FeeController::class, 'createExtraordinary'])->name('fees.createExtraordinary');
});

// Ruta para verTareas
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');

// Ruta para mostrar formulario crearTarea
Route::get('/tasks/formCreate', [TaskController::class, 'formCreate'])->name('tasks.formCreate');

// CrearTarea
Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store');

// Ruta para mostrar formulario modificarTarea
Route::get('/tasks/modify/{id}', [TaskController::class, 'formEdit'])->name('tasks.formEdit');

// ModificarTarea
Route::put('/tasks/update/{id}', [TaskController::class, 'update'])->name('tasks.update');

// EliminarTarea
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// VerTarea{ID}
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');

// Ruta para mostrar el formulario de completar tarea (GET)
Route::get('tasks/{task}/complete', [TaskController::class, 'showCompleteTask'])->name('tasks.showCompleteTask');

// ModificarTarea
Route::put('/tasks/{id}/complete', [TaskController::class, 'completeTask'])->name('tasks.completeTask');

// Ruta para acceder a la creación de una nueva tarea para un cliente
Route::get('/tasks/create/client', [TaskController::class, 'createTaskClient'])->name('tasks.create.client');

//Ruta para que el cliente cree una nueva tarea
Route::post('/tasks/create/client', [TaskController::class, 'storeClientTask'])->name('tasks.storeClientTask');

Route::get('/thanks-client', function () {
    return view('tasks.thanksClient');
})->name('tasks.thanks.client');

// Ruta para verClientes
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware('auth');

// Ruta para mostrar el formulario de creación de un cliente
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');

// Ruta para manejar la creación de un cliente
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

//Ruta para mostrar el formulario de modificación de un cliente
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');

//Ruta para modificar cliente
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');

// VerTarea{ID}
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('client.show');

// Ruta para ver usuarios operadores
Route::get('/users/oper', [OperUserController::class, 'index'])->name('operUsers.index')->middleware('auth');

// Ruta para crear un nuevo usuario operador
Route::get('/users/create', [OperUserController::class, 'create'])->name('operUsers.create');

// Ruta para almacenar el nuevo operador
Route::post('/users', [OperUserController::class, 'store'])->name('operUsers.store');

// Ruta para ver usuarios clientes
//Route::get('/users/client', [OperUserController::class, 'client'])->name('users.client');

Route::get('/fees/{id}', [FeeController::class, 'show'])->name('fees.show');

Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');

Route::delete('fees/{id}', [FeeController::class, 'destroy'])->name('fees.destroy');

// Define las rutas para el recurso de operUsers, usando 'user' en vez de 'operUser'
Route::resource('operUsers', OperUserController::class)->parameters([
    'operUsers' => 'user',  // Usa 'user' en vez de 'operUser'
]);
Route::resource('tasks', TaskController::class);
Route::resource('clients', ClientController::class);
Route::resource('provinces', ProvinceController::class);
Route::resource('fees', FeeController::class);

require __DIR__ . '/auth.php';
