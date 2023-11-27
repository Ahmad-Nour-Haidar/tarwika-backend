<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// public route

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/verify-code', 'verify');
        Route::post('/check-email', 'checkEmail');
        Route::post('/reset-password', 'resetPassword');
    });

Route::controller(TestController::class)
    ->prefix('test')
    ->group(function () {
        Route::get('/view', 'view');
    });


// protected route

// auth
Route::middleware([
    'auth:sanctum',
])
    ->controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/edit', 'edit');
        Route::delete('/logout', 'logout');
    });

// category
Route::middleware([
    'auth:sanctum',
])
    ->controller(CategoryController::class)
    ->prefix('category')
    ->group(function () {
        Route::get('/view', 'view');
    });

// item
Route::middleware([
    'auth:sanctum',
])
    ->controller(ItemController::class)
    ->prefix('item')
    ->group(function () {
        Route::get('/view/{category_id}', 'view');
        Route::get('/search', 'search');
    });

// favorite
Route::middleware([
    'auth:sanctum',
])
    ->controller(FavoriteController::class)
    ->prefix('favorite')
    ->group(function () {
        Route::get('/view', 'view');
        Route::post('/add', 'add');
        Route::delete('/delete/{item_id}', 'delete');
    });

// cart
Route::middleware([
    'auth:sanctum',
])
    ->controller(CartController::class)
    ->prefix('cart')
    ->group(function () {
        Route::get('/view', 'view');
        Route::get('/countItems', 'countItems');
        Route::post('/store', 'store');
        Route::get('/get-details-item/{item_id}', 'getDetailsItem');
        Route::delete('/delete/{item_id}', 'delete');
    });

// order
Route::middleware([
    'auth:sanctum',
])
    ->controller(OrderController::class)
    ->prefix('order')
    ->group(function () {
        Route::get('/view', 'view');
        Route::post('/order', 'order');
        Route::get('/details/{order_id}', 'details');
    });

