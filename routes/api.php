<?php

use App\Http\Controllers\Api\AllCommentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CommentControler;
use App\Http\Controllers\Api\MaintenanceController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/comments/all', [AllCommentController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/me', [AuthController::class, 'getMe']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'update']);

    Route::resource('/comments', CommentControler::class);

    Route::delete('/comments-all', [AllCommentController::class, 'destroy']);
});

Route::fallback(function () {
    return response()->json([
        'success'   => false,
        'data'      => [],
        'message'   => 'Invalid request or route',
    ], Response::HTTP_NOT_FOUND);
});
