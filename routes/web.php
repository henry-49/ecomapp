<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\ProductManager;

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


Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

Route::get('/', [ProductManager::class, 'index'])->name('home');

# Route::get('/products/create', [ProductManager::class, 'create'])->name('product.create');
// Route to view product details by slug
Route::get('/product/{slug}', [ProductManager::class, 'details'])->name('product.details');

Route::middleware("auth")->group(function () {
   // Route to add a product to the cart
    Route::get('/cart/{id}', [ProductManager::class, 'addToCart'])->name('cart.add');
    // Route to show the cart items
    Route::get('/cart', [ProductManager::class, 'showCart'])->name('cart.show');

    Route::get('/checkout', [OrderManager::class, 'showCheckout'])->name('checkout.show');#
    
    Route::post('/checkout', [OrderManager::class, 'processCheckout'])->name('checkout.post');
});