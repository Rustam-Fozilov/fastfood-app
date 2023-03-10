<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::delete('/products/{name}', [ProductController::class, 'destroy']);
Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/{id}', [ProductController::class, 'update']);
Route::get('/products-pagination', [ProductController::class, 'productsWithPagination']);
Route::post('/search', [SearchController::class, 'products']);
Route::get('/products-export', [ProductController::class, 'export']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/users', [UsersController::class, 'index']);
Route::post('/users/search', [UsersController::class, 'search']);
Route::post('/users', [UsersController::class, 'store']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::post('/users-pagination', [UsersController::class, 'usersWithPagination']);
Route::get('/users-export', [UsersController::class, 'export']);

Route::post('/confirm_order', [OrderController::class, 'store']);
Route::post('/orders', [OrderController::class, 'index']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::post('/orders-pagination', [OrderController::class, 'ordersWithPagination']);
Route::post('/orders/search', [OrderController::class, 'search']);
Route::get('/orders-export', [OrderController::class, 'export']);
