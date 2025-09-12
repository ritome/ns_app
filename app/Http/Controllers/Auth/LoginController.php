<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'employee_id' => ['required', 'string'],
                'password' => ['required', 'string'],
            ], [
                'employee_id.required' => '職員IDを入力してください。',
                'password.required' => 'パスワードを入力してください。',
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            throw ValidationException::withMessages([
                'employee_id' => ['ログイン情報が正しくありません。'],
            ]);
        } catch (ValidationException $e) {
            return back()
                ->withInput($request->only('employee_id', 'remember'))
                ->withErrors($e->errors());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
