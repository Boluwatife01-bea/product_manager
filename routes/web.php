<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Default Home Route (Redirect to Products Page)
Route::get('/', function () {
    return redirect()->route('products.index');
});

// CRUD Routes
Route::resource('products', ProductController::class);
