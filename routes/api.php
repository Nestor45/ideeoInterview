<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\API\AuthController;
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
Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
});
Route::get('/contactos', [ContactoController::class, 'index']);
Route::post('/registrar-contacto', [ContactoController::class, 'store']);
Route::put('/editar-contacto', [ContactoController::class, 'edit']);
Route::post('/eliminar-contacto', [ContactoController::class, 'destroy']);
