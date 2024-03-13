<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginRegisterController;
use App\Http\Controllers\EventController;
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



// Public routes of authtication
Route::controller(AuthLoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Rutas de usuario 
// Route::controller(UserController::class)->group(function(){
//     Route::get('/users', 'index');
//     Route::post('/users', 'store');
//     Route::put('/users/{id}', 'update');
//     Route::delete('/users/{id}', 'destroy');
// });

// Rutas de eventos
Route::controller(EventController::class)->group(function(){
    Route::get('/events', 'index');
    Route::post('/events', 'store');
    Route::put('/events/{id}', 'update');
    Route::delete('/events/{id}', 'destroy');

}); 
