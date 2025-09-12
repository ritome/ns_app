<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProgramCheckController;

// ホーム
Route::view('/', 'welcome')->name('home');

// 認証（ゲストのみアクセス可能）
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// 認証済みユーザー
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 育成プログラムチェックリスト
    Route::get('/program-checks', [ProgramCheckController::class, 'index'])->name('program-checks.index');
    Route::post('/program-checks/{item}/toggle', [ProgramCheckController::class, 'toggle'])->name('program-checks.toggle');
});
