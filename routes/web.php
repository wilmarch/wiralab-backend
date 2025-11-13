<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

// Import Semua Controller Admin
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EkatalogController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\TrainingRegistrationController;
use App\Http\Controllers\Admin\JobCategoryController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\UserController; 


// Route awal, redirect ke login
Route::get('/', function () {
    return Redirect::route('login');
});

// Route dashboard bawaan Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Grup untuk route yang memerlukan login (User Biasa & Admin) ---
Route::middleware('auth')->group(function () {
    
    // Route profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // === GRUP ADMIN YANG DIAMANKAN ===
    // Hanya user yang login DAN memiliki role 'superadmin' ATAU 'admin' yang bisa masuk
    Route::middleware(['role:superadmin,admin'])
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);
        
        // CRUD Item (Produk/Aplikasi)
        Route::resource('items', ItemController::class);
        
        // CRUD Blog
        Route::resource('blog', PostController::class);
        
        // E-Katalog
        Route::get('/e-katalog', [EkatalogController::class, 'index'])->name('ekatalog.index');
        Route::post('/e-katalog/update', [EkatalogController::class, 'update'])->name('ekatalog.update');
        
        // Kontak (Pesan Masuk) - Dibatasi
        Route::resource('kontak', MessageController::class)->only([
            'index', 'show', 'destroy'
        ]);
        
        // Pelatihan (Pengaturan)
        Route::resource('pelatihan', TrainingController::class); 
        Route::post('pelatihan-pdf-update', [TrainingController::class, 'updatePdf'])->name('pelatihan.updatePdf');
        
        // Pendaftar Pelatihan - Dibatasi
        Route::resource('pendaftar-pelatihan', TrainingRegistrationController::class)->only([
            'index', 'show', 'destroy'
        ]);
        
        // Karir (Pengaturan)
        Route::resource('pengaturan-karir', JobCategoryController::class)->names('job-categories');
        Route::post('karir-gform-update', [JobCategoryController::class, 'updateGform'])->name('careers.updateGform');
        
        // Karir (Lowongan)
        Route::resource('karir', CareerController::class)->names('careers');

        // --- MANAJEMEN USER (Hanya Superadmin) ---
        // Route ini HANYA bisa diakses oleh 'superadmin'
        Route::middleware(['role:superadmin'])
             ->resource('users', UserController::class);

    });
});

require __DIR__.'/auth.php';