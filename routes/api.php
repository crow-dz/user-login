<?php

use App\Http\Controllers\ImageController;
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

// Users
Route::controller(UserController::class)->group(function ($api) {
    $api->get('/users', 'getAllUsers')->name('all.users');
    $api->post('/users/login', 'login')->name('login.user');
    $api->get('/users/{user}', 'getUser')->name('get.user');
    $api->post('/users/register', 'createUser')->name('create.user');
    $api->put('/users/{user}/update', 'updateUser')->name('update.user');
    $api->delete('/users/{user}/delete', 'deleteUser')->name('delete.user');
});

// ImagesF
Route::controller(ImageController::class)->group(function ($api) {
    $api->post('/images', [ImageController::class, 'uploadImage'])->name('upload.image');
});
