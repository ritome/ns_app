@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md text-center">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">新入看護職員育成プログラム</h1>

            <p class="text-gray-600 mb-6">
                看護職員の成長と学びをサポートする総合的な育成プラットフォーム
            </p>

            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ダッシュボードへ
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        新規登録
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection

