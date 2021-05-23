<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {
    Route::get('categories/{id}/products', [App\Http\Controllers\Api\v1\CategoryController::class, 'products']);
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('products', 'ProductController');
});
