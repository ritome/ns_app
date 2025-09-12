@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">ログイン</h2>

            @error('employee_id')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">職員ID</label>
                    <input type="text" name="employee_id" id="employee_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('employee_id') border-red-500 @enderror"
                        value="{{ old('employee_id') }}" placeholder="例：N0001" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">パスワード</label>
                    <input type="password" name="password" id="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox h-5 w-5 text-blue-600"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">ログイン状態を保持する</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        ログイン
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
