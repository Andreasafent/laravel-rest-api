<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProductController;

Route::get('/', [AppController::class,'index']);

Route::get('/products', [ProductController::class,'index']);
Route::post('/products', [ProductController::class,'create']);
Route::get('/products/{id}', [ProductController::class,'show']);
Route::put('/products/{id}', [ProductController::class,'update']);
Route::delete('/products/{id}', [ProductController::class,'delete']);

