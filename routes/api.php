<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PropertyOwnerController;
use App\Http\Controllers\Api\PropertyController;
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

Route::get('/user', [UserController::class, 'index']);
Route::put('/user/image/{id}', [UserController::class, 'image'])->name('user.image');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::put('/user/email/{id}', [UserController::class, 'email'])->name('user.email');
Route::put('/user/password/{id}', [UserController::class, 'password'])->name('user.password');
Route::delete('/user/{id}', [UserController::class, 'destroy']);

//User Specific APIs = update of image based kong kinsa tong user nga ni log in
Route::get('/profile/show', [ProfileController::class, 'show']);
Route::put('/profile/image', [ProfileController::class, 'image'])->name('profile.image');

Route::controller(PropertyOwnerController::class)->group(function () {
    Route::get('/owner',               'index');
    Route::get('/owner/{id}',          'show');
    Route::post('/owner',              'store');
    Route::put('/owner/{id}',          'update');
    Route::delete('/owner/{id}',       'destroy');
});

Route::controller(PropertyController::class)->group(function () {
    Route::get('/property',               'index');
    Route::get('/property/{id}',          'show');
    Route::post('/property',              'store');
    Route::put('/property/{id}',          'update');
    Route::delete('/property/{id}',       'destroy');
});
