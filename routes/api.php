<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('auth', [App\Http\Controllers\Auth\AuthApiController::class, 'authenticate']);
Route::post('auth-refresh', [App\Http\Controllers\Auth\AuthApiController::class, 'refreshToken']);
Route::get('me', [App\Http\Controllers\Auth\AuthApiController::class, 'getAuthenticatedUser']);

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api\v1',
    'middleware' => 'auth:api'
], function () {
    Route::get('categories/{id}/products', [App\Http\Controllers\Api\v1\CategoryController::class, 'products']);
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('products', 'ProductController');
});
