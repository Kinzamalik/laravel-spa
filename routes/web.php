<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/customers', [CustomerController::class, 'search']);
Route::get('/api/products', [ProductController::class, 'search']);
Route::resource('/api/invoices', InvoiceController::class);

Route::resource('/api/customers', CustomerController::class);

// Route::get('/api/customers', [App\Http\Controllers\CustomerController::in]);
// Route::get('/api/products', [App\Http\Controllers\ProductController::class]);
// Route::resource('/api/invoices', [App\Http\Controllers\ProductController::class]);
