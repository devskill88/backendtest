<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\UserController;
use App\Models\ProductPrice;
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

Route::prefix('Auth')->group(function () {
    Route::post('/', [AuthController::class, 'getToken'])->name('auth.getToken');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('Auth/logOut', [AuthController::class, 'logout'])->name('auth.logOut');
    Route::get('Auth/requester', [AuthController::class, 'getRequester'])->name('auth.requester');

    Route::name('users.')->controller(UserController::class)->prefix('Users')->group(
        function () {
            Route::get('/',  'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/', 'create')->name('create');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'remove')->name('remove');
        }
    );

    Route::name('products.')->controller(ProductController::class)->prefix('Products')->group(
        function () {
            Route::get('/products',  'index')->name('index');
            Route::post('/products', 'create')->name('create');
            Route::get('/products/{id}', 'show')->name('show');
            Route::put('/{product}', 'update')->name('update');
            Route::delete('/{product}', 'remove')->name('remove');
        }
    );

    Route::prefix('products/{product}')->group(function () {

        Route::prefix('prices')->group(function () {
            Route::get('/', [ProductPriceController::class, 'getByProduct']);
            Route::post('/', [ProductPriceController::class, 'store']);
        });
    });
});
