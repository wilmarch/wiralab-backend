<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;

// Route awal
Route::get('/', function () {
    return Redirect::route('login');
});

// Route dashboard bawaan Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk route yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {

       // CRUD routes for Categories (Both Product & Application)
        // URL: /admin/categories, /admin/categories/create, etc.
        // Name: admin.categories.index, admin.categories.create, etc.
        Route::resource('categories', CategoryController::class);

        // CRUD routes for Items (Both Product & Application)
        // URL: /admin/items, /admin/items/create, etc.
        // Name: admin.items.index, admin.items.create, etc.
        Route::resource('items', ItemController::class);

        //Route Blog
        Route::get('/blog', function () {
            return view('admin.blog.index');
        })->name('blog.index');

        // Route Karir
        Route::get('/careers', function () {
            return view('admin.careers.index');
        })->name('careers.index');
    });
});

require __DIR__.'/auth.php';