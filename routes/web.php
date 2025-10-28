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

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class);
        Route::resource('blog', PostController::class);
        Route::get('/e-katalog', [EkatalogController::class, 'index'])->name('ekatalog.index');
        Route::post('/e-katalog/update', [EkatalogController::class, 'update'])->name('ekatalog.update');
        Route::resource('kontak', MessageController::class);
        Route::resource('pelatihan', TrainingController::class); 
        Route::post('pelatihan-pdf-update', [TrainingController::class, 'updatePdf'])->name('pelatihan.updatePdf');
        Route::resource('pendaftar-pelatihan', TrainingRegistrationController::class);


        // Route Karir (Biarkan ini dulu, akan kita kerjakan nanti)
        Route::get('/careers', function () {
            return view('admin.careers.index');
        })->name('careers.index');
    });
});

require __DIR__.'/auth.php';