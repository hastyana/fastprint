<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\Front\FrontPageController::class, 'index'])->name('index');
Route::get('/debug-api', [\App\Http\Controllers\Admin\ProductController::class, 'debugApi']);
Route::get('/fetch-products', [\App\Http\Controllers\Admin\ProductController::class, 'fetchProducts'])->name('fetch-products');  