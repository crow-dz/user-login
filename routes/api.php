<?php

use App\Http\Controllers\UserController;
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

Route::get('/user', [UserController::class,'getAllUsers'])->name('all.users');
Route::post('/user/login', [UserController::class,'login'])->name('login.user');
Route::get('/user/{user}', [UserController::class,'getUser'])->name('get.user');
Route::post('/user/register', [UserController::class,'createUser'])->name('create.user');
Route::put('/user/{user}/update', [UserController::class,'updateUser'])->name('update.user');
Route::delete('/user/{user}/delete', [UserController::class,'deleteUser'])->name('delete.user');


