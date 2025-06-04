<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('Dashboard.dashboard');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::middleware('auth')->group(function () {

// });
Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');
Route::get('/dashboard/branch', [BranchController::class, 'index'])->name('branch');
Route::get('/dashboard/category', [CategoryController::class, 'index'])->name('category');
Route::get('/dashboard/product', [ProductController::class, 'index'])->name('product');
Route::get('/dashboard/upload', [UploadController::class, 'index'])->name('upload');
Route::get('/dashboard/customer', [CustomerController::class, 'index'])->name('customer');
Route::get('/dashboard/position', [PositionController::class, 'index'])->name('position');
Route::get('/emloyee',[EmployeeController::class,'index'])->name('employee');


// require __DIR__.'/auth.php';
