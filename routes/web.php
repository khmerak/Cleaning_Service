<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Product_previewController;
use App\Http\Controllers\Api\Service_Category;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\Service_previewController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UserController;

// ✅ Home Page (requires login & email verification)
Route::get('/', function () {
    return view('Dashboard.dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('home');

// ✅ Authenticated user routes
Route::middleware('auth', 'role:admin')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard & Resource Routes
    Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');

    Route::get('/dashboard/branch', [BranchController::class, 'index'])->name('branch');
    Route::get('/dashboard/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/dashboard/product', [ProductController::class, 'index'])->name('product');
    Route::get('/dashboard/upload', [UploadController::class, 'index'])->name('upload');
    Route::get('/dashboard/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('/dashboard/position', [PositionController::class, 'index'])->name('position');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/dashboard/dashboard/service_category', [Service_Category::class, 'index'])->name('service_category');
    Route::get('/dashboard/services', [ServiceController::class, 'index'])->name('service');
    Route::get('/dashboard/product_preview', [Product_previewController::class, 'index'])->name('preview');
    Route::get('/dashboard/service_preview', [Service_previewController::class, 'index'])->name('service_preview');
    Route::get('/dashboard/user', [UserController::class, 'index'])->name('user');
    Route::get('/dashboard/order',[OrderController::class,'showOrder'])->name('showOrder');
});

// ✅ Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ✅ Auth Routes (login, register, etc.)
require __DIR__ . '/auth.php';
