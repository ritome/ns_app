<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $employee_id = '';
    public string $password = '';
    public bool $remember = false;

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
    }

    public function rules()
    {
        return [
            'employee_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => '職員IDを入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ];
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'employee_id' => $this->employee_id,
            'password' => $this->password,
        ], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('dashboard');
        }

        $this->addError('employee_id', __('auth.failed'));
        $this->reset('password');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.app');
    }
}
