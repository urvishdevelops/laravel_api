<?php
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class,"index"]);
Route::post('/studentView', [ProductController::class,"studentView"])->name('product.productview');
Route::get('/listing', [ProductController::class,"listing"])->name('product.listing');
Route::post('/edit', [ProductController::class,"studentView"])->name('product.edit');
Route::post('/delete', [ProductController::class,"studentView"])->name('product.delete');
?>