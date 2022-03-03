<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);
     
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('blogs', BlogController::class);
});