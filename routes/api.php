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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthLoginRegisterController::class, 'logout']);
});


// Public routes of authtication
Route::controller(AuthLoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
});


//Rutas de usuario 
Route::controller(UserController::class)->group(function(){
    Route::put('{id}/profile', 'updateProfile');
    Route::get('{id}/events','getEventsCreatedByUser');
    Route::put('{id}/update', 'updateProfile');
    Route::get('{id}/subscribed-events', 'getSubscribedEvents');
    
});

// Rutas de eventos
Route::controller(EventController::class)->group(function(){
    Route::get('/events', 'index');
    Route::post('/events/create', 'store'); // Crear un nuevo
    Route::put('/events/{id}/edit', 'update');
    Route::get('/events/{id}', 'show'); 
    Route::delete('/events/{id}/delete', 'destroy'); // Eliminar uno

}); 

