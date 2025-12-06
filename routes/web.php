<?php

use Illuminate\Support\Facades\Route;

/**
 * Test Routes 
 */

// Route::get('/hello-world', function () {
//     return "Hello World";
// })->middleware('auth');

/**
 * Auth Routes 
 */

use App\Http\Controllers\AuthController;

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/**
 * Dashboard Routes 
 */

use App\Http\Controllers\DashboardController;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('auth');
