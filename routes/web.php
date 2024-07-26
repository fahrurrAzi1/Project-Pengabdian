<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;

Route::get('/', function () {
    // fungsi auto login jika lupa log-out
    if (auth()->check()) {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect('/');
        }
    }
    // selesai

    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::aliasMiddleware('role', RoleMiddleware::class);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });
    
    Route::middleware(['auth', 'role:guru'])->group(function () {
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.dashboard');
        Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
        Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
        Route::post('/guru/mark-answer/{id}', [GuruController::class, 'markAnswer']);
    });
    
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
        Route::post('/siswa/jawaban/{content}',[SiswaController::class, 'submitJawaban'])->name('siswa.submit_jawaban');
        Route::get('/dashboard-selesai', [SiswaController::class, 'selesai'])->name('siswa.dashboard_selesai');
    });
});

Route::post('/ckeditor/upload', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.upload');

require __DIR__.'/auth.php';
