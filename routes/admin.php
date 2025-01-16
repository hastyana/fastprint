<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['web'],
], function() {
    Route::get('/', function() {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->middleware('throttle:10,1');
    });

    Route::middleware('auth:admin')->group(function () {
        // Logout route
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
        
        // Dashboard route
        Route::get('dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

        // Product route
        Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
    });
});