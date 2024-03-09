<?php

use Illuminate\Http\Request;
use App\Models\LandClassification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyOwnerController;
use App\Http\Controllers\Api\RealPropertyTaxController;
use App\Http\Controllers\Api\LandClassificationController;

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

//Public APIs
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

// Admin
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/all', [UserController::class, 'all']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/image/{id}', [UserController::class, 'image'])->name('user.image');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::put('/user/name/{id}', [UserController::class, 'name'])->name('user.name');
    Route::put('/user/email/{id}', [UserController::class, 'email'])->name('user.email');
    Route::put('/user/password/{id}', [UserController::class, 'password'])->name('user.password');
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    //User Specific APIs = update of image based kong kinsa tong user nga ni log in
    Route::get('/profile/show', [ProfileController::class, 'show']);
    Route::put('/profile/image', [ProfileController::class, 'image'])->name('profile.image');

    Route::controller(PropertyOwnerController::class)->group(function () {
        Route::get('/owner',               'index');
        Route::get('/owner/all',               'all');
        Route::get('/owner/{id}',          'show');
        Route::post('/owner',              'store');
        Route::get('/owner/property/{id}',   'viewProperty');
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

    Route::controller(LandClassificationController::class)->group(function () {
        Route::get('/classification',               'index');
        Route::get('/classification/{id}',          'show');
        Route::post('/classification',              'store');
        Route::put('/classification/{id}',          'update');
        Route::delete('/classification/{id}',       'destroy');
    });

    Route::controller(RealPropertyTaxController::class)->group(function () {
        Route::get('/tax',               'index');
        Route::get('/tax/{id}',          'show');
        Route::post('/tax',              'store');
        Route::put('/tax/{id}',          'update');
        Route::delete('/tax/{id}',       'destroy');
    });

    Route::get('/statistics', [QueryController::class, 'statistics']);
    Route::get('/statistics/owners', [QueryController::class, 'statisticsOwners']);
});
