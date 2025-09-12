@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col justify-center bg-gradient-to-br from-sky-50 via-indigo-50/50 to-emerald-50/30">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center mb-6">
                <h2 class="text-xl font-medium text-slate-900">
                    新入看護職員育成プログラム
                </h2>
            </div>

            <div class="bg-white py-8 px-4 shadow-sm ring-1 ring-slate-900/5 sm:rounded-lg sm:px-10">
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4">
                        <div class="ml-3">
                            <div class="text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-slate-700">
                            職員ID
                        </label>
                        <div class="mt-1">
                            <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                                required autofocus
                                class="block w-full appearance-none rounded-md border border-slate-300 px-3 py-2 shadow-sm placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm"
                                placeholder="例：N0001">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">
                            パスワード
                        </label>
                        <div class="mt-1">
                            <input type="password" name="password" id="password" required
                                class="block w-full appearance-none rounded-md border border-slate-300 px-3 py-2 shadow-sm placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-slate-700">
                                ログイン状態を保持する
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-gradient-to-r from-sky-500 to-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:from-sky-600 hover:to-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">
                            ログイン
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
