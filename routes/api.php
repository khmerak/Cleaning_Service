<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\Product_previewController;
use App\Http\Controllers\Api\ProductAddToCartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Service_Category as ApiService_Category;
use App\Http\Controllers\Api\Service_previewController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;

Route::get('/branches', [BranchController::class, 'get'])->name('branches');
Route::post('/branches', [BranchController::class, 'store'])->name('branches_store');
Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches_update');
Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches_destroy');

Route::get('/categories', [CategoryController::class, 'get'])->name('categories');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories_store');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories_update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories_destroy');

Route::get('/products', [ProductController::class, 'get'])->name('products');
Route::post('/products', [ProductController::class, 'store'])->name('products_store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products_update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products_destroy');

Route::get('/uploads', [UploadController::class, 'get'])->name('uploads');
Route::post('/uploads', [UploadController::class, 'store'])->name('uploads_store');
Route::put('/uploads/{id}', [UploadController::class, 'update'])->name('uploads_update');
Route::delete('/uploads/{id}', [UploadController::class, 'destroy'])->name('uploads_destroy');

Route::get('/customers', [CustomerController::class, 'get'])->name('customers');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers_store');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers_update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers_destroy');

Route::get('/positions', [PositionController::class, 'get'])->name('positions');
Route::post('/positions', [PositionController::class, 'store'])->name('positions_store');
Route::put('/positions/{id}', [PositionController::class, 'update'])->name('positions_update');
Route::delete('/positions/{id}', [PositionController::class, 'destroy'])->name('positions_destroy');


Route::get('/employees', [EmployeeController::class, 'get'])->name('employee');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employee_store');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employee_update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employee_delete');

Route::get('/service_categories', [ApiService_Category::class, 'get'])->name('service_categories');
Route::post('/service_categories', [ApiService_Category::class, 'store'])->name('service_categories_store');
Route::put('/service_categories/{id}', [ApiService_Category::class, 'update'])->name('service_categories_update');
Route::delete('/service_categories/{id}', [ApiService_Category::class, 'destroy'])->name('service_categories_destroy');

Route::get('/get_services', [ServiceController::class, 'get_service'])->name('get');
Route::get('/services', [ServiceController::class, 'get'])->name('get_services');
Route::post('/services', [ServiceController::class, 'store'])->name('store_service');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('update_service');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('delete_service');

Route::get('/users', [UserController::class, 'get'])->name('get_users');
Route::post('/users', [UserController::class, 'store'])->name('store_user');
Route::put('/users/{id}', [UserController::class, 'update'])->name('update_user');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('delete_user');

Route::get('/product_previews', [Product_previewController::class, 'get'])->name('product_previews');

Route::get('/service_previews', [Service_previewController::class, 'get'])->name('service_previews');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/order_items',[OrderController::class, 'get']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('cart/add', [ProductAddToCartController::class, 'addToCart']);
    Route::apiResource('/cart',ProductAddToCartController::class);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->put('/cart/{id}', [ProductAddToCartController::class, 'update']);
// routes/api.php
Route::middleware('auth:sanctum')->post('/checkout', [OrderController::class, 'store']);
Route::middleware('auth:sanctum')->get('/invoices', [InvoiceController::class, 'index']);
Route::middleware('auth:sanctum')->get('/orders', [OrderController::class, 'index']);



