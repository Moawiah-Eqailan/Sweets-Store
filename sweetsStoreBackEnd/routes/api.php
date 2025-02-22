<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDeliveryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(CategoryController::class)->prefix('Categories')->group(function () {
    Route::get('', 'index')->name('Categories');
    Route::get('create', 'create')->name('Categories.create');
    Route::post('store', 'store')->name('Categories.store');
    Route::get('show/{id}', 'show')->name('Categories.show');
    Route::get('edit/{id}', 'edit')->name('Categories.edit');
    Route::put('edit/{id}', 'update')->name('Categories.update');
    Route::delete('destroy/{id}', 'destroy')->name('Categories.destroy');
    Route::get('/searchh', 'searchh')->name('searchh');
});


Route::get('app', [CategoryController::class, 'app']);


Route::get('products', [ProductController::class, 'products']);
Route::get('SubFilter', [ProductController::class, 'SubFilter']);

Route::post('loginUsers', [AuthController::class, 'loginUsers']);
Route::post('registerUsers', [AuthController::class, 'registerUsers']);


Route::get('sideBar', [ItemController::class, 'sideBar']);
Route::get('ItemProduct', [ItemController::class, 'ItemProduct']);
Route::get('Filter', [ItemController::class, 'Filter']);


Route::post('ContactUs', [ContactController::class, 'ContactUs']);





Route::put('updateUser', [UserController::class, 'updateUser']);






Route::post('addToCartUsersSide', [CartController::class, 'addToCartUsersSide']);

Route::post('CartUsersSide', [CartController::class, 'CartUsersSide']);

Route::delete('/cart/{cartId}', [CartController::class, 'removeCartItem']);

Route::post('clearCartUsersSide', [CartController::class, 'clearCartUsersSide']);
Route::get('topProducts', [CartController::class, 'topProducts']);





Route::post('order', [OrderController::class, 'order']);
Route::post('usersOrderItem', [OrderController::class, 'usersOrderItem']);
Route::get('/user-orders', [OrderController::class, 'getUserOrders']);




Route::post('/orderDelivery', [OrderDeliveryController::class, 'store']);
