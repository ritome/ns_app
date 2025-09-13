@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- 職員ID -->
        <div>
            <x-input-label for="employee_id" value="職員ID" />
            <x-text-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')"
                required autofocus autocomplete="employee_id" placeholder="例：N0001" />
            <p class="mt-1 text-sm text-gray-500">大文字アルファベット1文字と4桁の数字（例：N0001）</p>
            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
        </div>

        <!-- 氏名 -->
        <div class="mt-4">
            <x-input-label for="full_name" value="氏名" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')"
                required autocomplete="name" placeholder="山田 花子" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- 入職日 -->
        <div class="mt-4">
            <x-input-label for="hire_date" value="入職日" />
            <x-text-input id="hire_date" class="block mt-1 w-full" type="date" name="hire_date" :value="old('hire_date')"
                required />
            <x-input-error :messages="$errors->get('hire_date')" class="mt-2" />
        </div>

        <!-- パスワード -->
        <div class="mt-4">
            <x-input-label for="password" value="パスワード" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <p class="mt-1 text-sm text-gray-500">8文字以上の英数字を組み合わせてください</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- パスワード（確認） -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="パスワード（確認）" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                href="{{ route('login') }}">
                すでに登録済みの方はこちら
            </a>

            <x-primary-button class="ml-4">
                新規登録
            </x-primary-button>
        </div>
    </form>
@endsection
