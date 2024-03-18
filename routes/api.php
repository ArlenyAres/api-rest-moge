<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginRegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthLoginRegisterController::class, 'register']);
Route::post('/login', [AuthLoginRegisterController::class, 'login']);

// Rutas de autenticacion
Route::middleware(['cors'])->group(function () {
    Route::post('/logout', [AuthLoginRegisterController::class, 'logout'])->middleware('auth:sanctum');
});

// Rutas de usuario
Route::middleware(['cors'])->group(function () {
    Route::put('{id}/profile', [UserController::class, 'updateProfile']);
    Route::get('{id}/events', [UserController::class, 'getEventsCreatedByUser']);
    Route::put('{id}/update', [UserController::class, 'updateProfile']);
    Route::get('/{id}/subscribed-events', [UserController::class, 'getSubscribedEvents']);
});

// Rutas de eventos
Route::middleware(['cors'])->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/category/{id}', [EventController::class, 'indexByCategory']);
    Route::post('/events/create', [EventController::class, 'store']);
    Route::put('/events/{id}/edit', [EventController::class, 'update']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::delete('/events/{id}/delete', [EventController::class, 'destroy']);
    Route::get('/events/{id}/registered-users', [EventController::class, 'getRegisteredUsers']);
});


// Ruta de Sanctum
Route::middleware(['auth:sanctum', 'cors'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/logout', [AuthLoginRegisterController::class, 'logout']);
// });

// // Route::group(['middleware' => ['cors']], function () {
// //     //Rutas a las que se permitirá acceso
// // });


// // Public routes of authtication
// Route::controller(AuthLoginRegisterController::class)->group(function() {
//     Route::post('/register', 'register');
//     Route::post('/login', 'login');
//     Route::get('/logout', 'logout');
// });


// //Rutas de usuario 
// Route::controller(UserController::class)->group(function(){
//     Route::put('{id}/profile', 'updateProfile');
//     Route::get('{id}/events','getEventsCreatedByUser');
//     Route::put('{id}/update', 'updateProfile');
//     Route::get('{id}/subscribed-events', 'getSubscribedEvents');
    
// });

// // Rutas de eventos
// Route::controller(EventController::class)->group(function(){
//     Route::get('/events', 'index');
//     Route::post('/events/create', 'store'); // Crear un nuevo
//     Route::put('/events/{id}/edit', 'update');
//     Route::get('/events/{id}', 'show'); 
//     Route::delete('/events/{id}/delete', 'destroy'); // Eliminar uno

// }); 

