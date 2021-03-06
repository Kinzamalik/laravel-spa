<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/customers/search', [CustomerController::class, 'search']);
Route::get('/api/products/search', [ProductController::class, 'search']);
Route::resource('/api/invoices', InvoiceController::class);

Route::resource('/api/customers', CustomerController::class);
Route::resource('/api/vendors', VendorController::class);
Route::resource('/api/products', ProductController::class);
// Route::resource('/api/vendors', ProductController::class);

