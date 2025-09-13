<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '新入看護職員育成プログラム') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- サイドバー -->
        <div class="w-64 bg-white shadow-lg flex-shrink-0 {{ request()->routeIs('login') ? 'hidden' : '' }}">
            <div class="h-full flex flex-col">
                <!-- ロゴ -->
                <div class="h-14 bg-blue-500 flex items-center px-4">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white truncate">
                        看護職員育成プログラム
                    </a>
                </div>

                <!-- ナビゲーション -->
                <div class="flex-1 overflow-y-auto">
                    <nav class="px-2 py-3 space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            マイページ
                        </a>

                        <a href="{{ route('program-checks.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                {{ request()->routeIs('program-checks.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            育成プログラム
                        </a>
                    </nav>
                </div>

                <!-- ユーザー情報 -->
                @auth
                    <div class="border-t border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                        ログアウト
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- メインコンテンツ -->
        <div class="flex-1 overflow-y-auto">
            <main class="py-8">
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
