<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;

// --- BAGIAN INI KUNCINYA ---

// 1. Kalau buka halaman awal ('/'), tampilkan file 'welcome.blade.php'
Route::get('/', function () {
    return view('welcome');
});

// 2. Halaman Menu Kopi digeser ke alamat '/menu', TAPI namanya tetap 'home'
Route::get('/menu', [ShopController::class, 'index'])->name('home');

// ---------------------------

// Auth (Login/Register/Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Fitur Belanja (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/cart/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [ShopController::class, 'deleteCart'])->name('cart.delete');
    Route::patch('/cart/{id}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    
    // History & Admin
    Route::get('/history', [ShopController::class, 'history'])->name('history');
    Route::get('/admin/orders', [ShopController::class, 'adminOrders'])->name('admin.orders');

    // Admin Product
    Route::put('/product/{id}', [ShopController::class, 'updateProduct'])->name('product.update');
    Route::post('/product', [ShopController::class, 'store'])->name('product.store');

    // Route Dashboard Admin (BARU)
    Route::get('/admin/dashboard', [ShopController::class, 'adminDashboard'])->name('admin.dashboard');

    // Route Galeri Menu
    Route::get('/menu-gallery', [ShopController::class, 'menuGallery'])->name('menu.gallery');
});