<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(): void
    {
        // レート制限の設定
        RateLimiter::for('login', function (Request $request) {
            $key = $request->input('employee_id') . '|' . $request->ip();
            return [
                Limit::perMinute(5)->by($key),
            ];
        });

        // ログインビューの設定
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // カスタム認証メソッド
        Fortify::authenticateUsing(function (Request $request) {
            Log::info('Login attempt', ['employee_id' => $request->employee_id]);

            $user = User::where('employee_id', $request->employee_id)->first();

            if (!$user) {
                Log::warning('User not found', ['employee_id' => $request->employee_id]);
                return null;
            }

            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Invalid password', ['employee_id' => $request->employee_id]);
                return null;
            }

            Log::info('Login successful', [
                'employee_id' => $user->employee_id,
                'name' => $user->name
            ]);

            return $user;
        });
    }
}
