<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
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
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\BlogCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // === GRUP ADMIN (Bisa diakses Superadmin & Admin) ===
    Route::middleware(['role:superadmin,admin'])
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {

        // --- Modul Konten ---
        Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class);
        Route::resource('blog', PostController::class);
        Route::resource('blog-categories', BlogCategoryController::class)->names('blog-categories');
        
        Route::get('/e-katalog', [EkatalogController::class, 'index'])->name('ekatalog.index');
        Route::post('/e-katalog/update', [EkatalogController::class, 'update'])->name('ekatalog.update');
        
        Route::resource('kontak', MessageController::class)->only(['index', 'show', 'destroy']);
        
        Route::resource('pelatihan', TrainingController::class); 
        Route::post('pelatihan-pdf-update', [TrainingController::class, 'updatePdf'])->name('pelatihan.updatePdf');
        Route::resource('pendaftar-pelatihan', TrainingRegistrationController::class)->only(['index', 'show', 'destroy']);
        
        Route::resource('pengaturan-karir', JobCategoryController::class)->names('job-categories');
        Route::post('karir-gform-update', [JobCategoryController::class, 'updateGform'])->name('careers.updateGform');
        Route::resource('karir', CareerController::class)->names('careers');
        Route::resource('perusahaan', CompanyController::class)->names('companies');
        Route::resource('lokasi', LocationController::class)->names('locations');

        
        // --- GRUP KHUSUS SUPERADMIN (HANYA Manajemen User) ---
        Route::middleware(['role:superadmin'])
             ->group(function () {
            
            Route::resource('users', UserController::class);

        });
    });
});

require __DIR__.'/auth.php';