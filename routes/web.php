<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GenerateController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\StopwordController;

// ═══════════════════════════════════════════
//  JALUR PUBLIK — Pelanggan
// ═══════════════════════════════════════════
Route::prefix('/')->name('public.')->group(function () {
    Route::get('/',            [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/produk/{product}', [CatalogController::class, 'show'])->name('catalog.show');
    // Tentang
    Route::get('/tentang', [AboutController::class, 'index'])->name('about');

    // Kontak
    Route::get('/kontak',         [ContactController::class, 'index'])->name('contact');
    Route::post('/kontak/kirim',  [ContactController::class, 'send'])->name('contact.send');

});

// ═══════════════════════════════════════════
//  JALUR ADMIN — Auth (tanpa middleware)
// ═══════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // ── Halaman yang butuh login (pakai middleware AdminAuth) ──
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kategori
        Route::resource('category', CategoryController::class);

        // Produk
        Route::resource('product', ProductController::class);

        

        // Generate TF-IDF
        Route::get('/generate',             [GenerateController::class, 'index'])->name('generate.index');
        Route::post('/generate/run',        [GenerateController::class, 'run'])->name('generate.run');
        Route::post('/generate/preprocessing',  [GenerateController::class, 'preprocessing'])->name('generate.preprocessing');
        Route::post('/generate/normalization',  [GenerateController::class, 'normalization'])->name('generate.normalization');
        Route::post('/generate/similarity',     [GenerateController::class, 'similarity'])->name('generate.similarity');

        // Stopword
        Route::get('/stopword',          [StopwordController::class, 'index'])->name('stopword.index');
        Route::post('/stopword',         [StopwordController::class, 'store'])->name('stopword.store');
        Route::post('/stopword/bulk',    [StopwordController::class, 'bulkStore'])->name('stopword.bulk');
        Route::delete('/stopword/{id}',  [StopwordController::class, 'destroy'])->name('stopword.destroy');
        Route::post('/stopword/reset',   [StopwordController::class, 'reset'])->name('stopword.reset');
    });
});
