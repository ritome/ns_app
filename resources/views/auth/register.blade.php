@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">新規登録</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">職員ID</label>
                    <input type="text" name="employee_id" id="employee_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="例：N0001" required autofocus>
                    <p class="text-gray-600 text-xs mt-1">
                        大文字アルファベット1文字と4桁の数字の形式で入力してください（例：N0001）
                    </p>
                    @error('employee_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">名前（表示名）</label>
                    <input type="text" name="name" id="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">氏名（フルネーム）</label>
                    <input type="text" name="full_name" id="full_name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('full_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">役割</label>
                    <select name="role" id="role"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                        <option value="new_nurse">新入看護職員</option>
                        <option value="partner_nurse">パートナー看護師</option>
                        <option value="educator">教育係</option>
                        <option value="chief">主任</option>
                        <option value="manager_safety">課長（医療安全）</option>
                        <option value="manager_infection">課長（感染制御）</option>
                        <option value="manager_hrd">課長（人材育成）</option>
                        <option value="director">部長</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">パスワード</label>
                    <input type="password" name="password" id="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">パスワード確認</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        新規登録
                    </button>
                    <a href="{{ route('login') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        ログインはこちら
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
