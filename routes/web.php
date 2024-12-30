<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index']);
Route::get('categories/{slug}', [App\Http\Controllers\Web\CategoryController::class, 'show'])->name('categories.show');
Route::get('book/{slug}', [App\Http\Controllers\Web\BookController::class, 'show'])->name('books.show');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
    // route category
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    //route slider
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    // route books
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class);
    // route book images
    Route::get('books/{book}/images/add', [\App\Http\Controllers\Admin\BookController::class, 'addImages'])->name('books.add-images');
    Route::post('books/{book}/images', [\App\Http\Controllers\Admin\BookController::class, 'storeImages'])->name('books.store-images');
    Route::delete('books/images/{image}', [\App\Http\Controllers\Admin\BookController::class, 'removeBookImage'])->name('books.delete-image');
    // route transactions
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class);
});

Route::group(['as' => 'customers.', 'prefix' => 'customers', 'middleware' => ['auth','role:customer']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    // route transactions
    Route::resource('transactions', \App\Http\Controllers\Customer\TransactionController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\Web\CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [App\Http\Controllers\Web\CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{book_id}', [App\Http\Controllers\Web\CartController::class, 'deleteCartItem'])->name('cart.delete');
    Route::get('/cart/get-cities', [App\Http\Controllers\Web\CartController::class, 'getCities'])->name('cart.getCities');
    Route::post('/cart/shipping-cost', [App\Http\Controllers\Web\CartController::class, 'getShippingCost'])->name('cart.getShippingCost');
    Route::post('/checkout', [App\Http\Controllers\Web\CheckoutController::class, 'index'])->name('checkout.index');
});