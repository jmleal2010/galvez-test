<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::prefix('checklist')
    ->group(function () {
        Route::get('/', [ChecklistController::class, 'index']);
        Route::post('/', [ChecklistController::class, 'store']);
        Route::get('/identify', [ChecklistController::class, 'identify']);
        Route::put('/', [ChecklistController::class, 'update']);
        Route::delete('/', [ChecklistController::class,'destroy']);
    });
