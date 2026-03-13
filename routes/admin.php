<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\LeadAdminController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\InfographicAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
| Prefix: /admin
| Name prefix: admin.
| Middleware: web, auth, admin
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Categories CRUD
Route::resource('categories', CategoryAdminController::class)->except(['show']);

// Products CRUD
Route::resource('products', ProductAdminController::class);
Route::patch('products/{product}/toggle', [ProductAdminController::class, 'toggle'])->name('products.toggle');

// Orders management
Route::get('orders/export/csv', [OrderAdminController::class, 'exportCsv'])->name('orders.export');
Route::resource('orders', OrderAdminController::class)->only(['index', 'show', 'update']);
Route::patch('orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.status');

// Leads management
Route::get('leads/export/csv', [LeadAdminController::class, 'exportCsv'])->name('leads.export');
Route::resource('leads', LeadAdminController::class)->only(['index', 'show', 'destroy']);

// Blog CRUD
Route::resource('blog', BlogAdminController::class);

// Infographics CRUD
Route::resource('infographics', InfographicAdminController::class)->except(['show']);
