<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramCheckController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DailyNoteController;

// ホーム（認証済みの場合はダッシュボードへ）
Route::redirect('/', '/dashboard');

// 認証（ゲストのみアクセス可能）
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// 認証済みユーザー
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 育成プログラム
    Route::get('/program-checks', [ProgramCheckController::class, 'index'])->name('program-checks.index');
    Route::post('/program-checks/{item}/toggle', [ProgramCheckController::class, 'toggle'])->name('program-checks.toggle');

    // 振り返りシート
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

    // 日々の振り返り
    Route::get('/daily-notes', [DailyNoteController::class, 'index'])->name('daily-notes.index');
    Route::post('/daily-notes', [DailyNoteController::class, 'store'])->name('daily-notes.store');
});
