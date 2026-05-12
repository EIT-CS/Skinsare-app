<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkinTestController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/tips', [ProductController::class, 'tips'])->name('tips.index');

// Skin Test (accessible to guests too)
Route::get('/test', [SkinTestController::class, 'show'])->name('test.show');
Route::post('/test', [SkinTestController::class, 'submit'])->name('test.submit');

// ============================================
// GUEST ONLY ROUTES
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');
    Route::get('/verify-reset-code', [AuthController::class, 'showVerifyResetCode'])->name('password.verify');
    Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode'])->name('password.verify.submit');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ============================================
// AUTHENTICATED ROUTES
// ============================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Tips
    Route::get('/tips', [AdminController::class, 'tips'])->name('tips');
    Route::get('/tips/create', [AdminController::class, 'createTip'])->name('tips.create');
    Route::post('/tips', [AdminController::class, 'storeTip'])->name('tips.store');
    Route::get('/tips/{tip}/edit', [AdminController::class, 'editTip'])->name('tips.edit');
    Route::put('/tips/{tip}', [AdminController::class, 'updateTip'])->name('tips.update');
    Route::delete('/tips/{tip}', [AdminController::class, 'deleteTip'])->name('tips.delete');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
});

Route::get('/css/app.css', function () {
    return response()->file(resource_path('css/app.css'), [
        'Content-Type' => 'text/css',
    ]);
});

Route::get('/js/app.js', function () {
    return response()->file(resource_path('js/app.js'), [
        'Content-Type' => 'application/javascript',
    ]);
});
