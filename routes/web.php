<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramCheckController;
use App\Http\Controllers\ProgramScheduleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DailyNoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // 育成プログラム表
    Route::get('/program-schedule', [ProgramScheduleController::class, 'index'])
        ->name('program-schedule');

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // 育成プログラム（チェックリスト）
    Route::prefix('program-checks')->name('program-checks.')->group(function () {
        Route::get('/', [ProgramCheckController::class, 'index'])
            ->name('index');
        Route::get('/approver', [ProgramCheckController::class, 'approverIndex'])
            ->name('approver.index');
        Route::get('/approver/{user}', [ProgramCheckController::class, 'approverShow'])
            ->name('approver.show');
        Route::post('/toggle/{program_item}', [ProgramCheckController::class, 'toggle'])
            ->name('toggle');
    });

    // 振り返りシート
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])
            ->name('index');
        Route::get('/create', [ReviewController::class, 'create'])
            ->name('create');
        Route::post('/', [ReviewController::class, 'store'])
            ->name('store');
        Route::get('/{review}', [ReviewController::class, 'show'])
            ->name('show');
        Route::get('/{review}/edit', [ReviewController::class, 'edit'])
            ->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])
            ->name('update');
        Route::post('/{review}/submit', [ReviewController::class, 'submit'])
            ->name('submit');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])
            ->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])
            ->name('reject');
    });

    // 日々の振り返り
    Route::prefix('daily-notes')->name('daily-notes.')->group(function () {
        Route::get('/', [DailyNoteController::class, 'index'])
            ->name('index');
        Route::get('/create', [DailyNoteController::class, 'create'])
            ->name('create');
        Route::post('/', [DailyNoteController::class, 'store'])
            ->name('store');
        Route::get('/{dailyNote}', [DailyNoteController::class, 'show'])
            ->name('show');
        Route::get('/{dailyNote}/edit', [DailyNoteController::class, 'edit'])
            ->name('edit');
        Route::put('/{dailyNote}', [DailyNoteController::class, 'update'])
            ->name('update');
        // コメント関連
        Route::prefix('{dailyNote}/comments')->name('comments.')->group(function () {
            Route::post('/', [DailyNoteController::class, 'storeComment'])->name('store');
            Route::get('/{dailyComment}/edit', [DailyNoteController::class, 'editComment'])->name('edit');
            Route::put('/{dailyComment}', [DailyNoteController::class, 'updateComment'])->name('update');
            Route::delete('/{dailyComment}', [DailyNoteController::class, 'deleteComment'])->name('destroy');
        });
    });
});
