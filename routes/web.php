<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [UserController::class, 'register'])->name('register');

Route::middleware('auth')->get('/home', [UserController::class, 'showHome'])->name('home');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/orders/print/{order}', [OrderController::class, 'printInvoice'])->name('orders.print');
    Route::get('/orders/invoice/{userId}', [OrderController::class, 'generateInvoice'])->name('orders.invoice');
    
    Route::get('/ordermanager', [OrderController::class, 'orderManagerIndex'])->name('ordermanager.index');
    
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/search-menu', [MenuController::class, 'search'])->name('menus.search'); // Assume you want to handle search via GET request
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/usermanager', [UserController::class, 'index'])->name('usermanager.index');
    Route::get('/usermanager/create', [UserController::class, 'create'])->name('usermanager.create');
    Route::post('/usermanager', [UserController::class, 'store'])->name('usermanager.store');
    Route::get('/usermanager/{user}', [UserController::class, 'show'])->name('usermanager.show');
    Route::get('/usermanager/{user}/edit', [UserController::class, 'edit'])->name('usermanager.edit');
    Route::put('/usermanager/{user}', [UserController::class, 'update'])->name('usermanager.update');
    Route::delete('/usermanager/{user}', [UserController::class, 'destroy'])->name('usermanager.destroy');
});
