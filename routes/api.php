<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/chat/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/store', [ChatController::class, 'store']);
    Route::get('/chat/listMessagesByFriend/{logged_user}/{friend}', [ChatController::class, 'list_messages_by_friend']);
    Route::post('/chat/readMessages', [ChatController::class, 'readMessages']);
});
