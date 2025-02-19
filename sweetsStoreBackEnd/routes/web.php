<?php

use App\Mail\Email;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('admon.logout', 'logout')->middleware('auth')->name('logout');
});



// Protected routes
Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('sidebar', function () {
    return view('layouts\sidebar');
})->name('sidebar');

Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');

// Product Routes
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('products');
    Route::get('create', 'create')->name('products.create');
    Route::post('store', 'store')->name('products.store');
    Route::get('show/{id}', 'show')->name('products.show');
    Route::get('edit/{id}', 'edit')->name('products.edit');
    Route::put('edit/{id}', 'update')->name('products.update');
    Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
    Route::get('/search', 'search')->name('search');
});

// Category Routes
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

// Item Routes
Route::controller(ItemController::class)->prefix('Items')->group(function () {
    Route::get('', 'index')->name('Items');
    Route::get('create', 'create')->name('Items.create');
    Route::post('store', 'store')->name('Items.store');
    Route::get('show/{id}', 'show')->name('Items.show');
    Route::get('edit/{id}', 'edit')->name('Items.edit');
    Route::put('edit/{id}', 'update')->name('Items.update');
    Route::delete('destroy/{id}', 'destroy')->name('Items.destroy');
    Route::get('/searrchh', 'searrchh')->name('searrchh');
});

// User Routes
Route::controller(UserController::class)->prefix('Users')->group(function () {
    Route::get('', 'index')->name('Users');
    Route::get('create', 'create')->name('Users.create');
    Route::post('store', 'store')->name('Users.store');
    Route::get('show/{id}', 'show')->name('Users.show');
    Route::get('edit/{id}', 'edit')->name('Users.edit');
    Route::put('edit/{id}', 'update')->name('Users.update');
    Route::delete('destroy/{id}', 'destroy')->name('Users.destroy');
    Route::get('/ssearchh', 'ssearchh')->name('ssearchh');
});

// Contact Route
Route::controller(ContactController::class)->prefix('Contact')->group(function () {
    Route::get('', 'index')->name('Contact');
    Route::get('show/{id}', 'show')->name('Contact.show');
    Route::delete('destroy/{id}', 'destroy')->name('Contact.destroy');
});


// Profile Route
Route::get('profile', [AuthController::class, 'profile'])->name('profile');
