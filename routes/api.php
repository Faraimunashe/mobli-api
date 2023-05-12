<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['cors'])->group(function () {

});


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //transport
    Route::post('/transport', [TransportController::class, 'add']);
    Route::post('/service', [TransportController::class, 'add_service']);
    Route::get('/transport', [TransportController::class, 'index']);
    Route::get('/transport/{id}', [TransportController::class, 'one']);
});
