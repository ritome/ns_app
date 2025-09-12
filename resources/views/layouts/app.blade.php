<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>新入看護職員育成プログラム</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- サイドナビゲーション -->
        <aside class="fixed inset-y-0 left-0 hidden w-56 overflow-y-auto bg-white border-r border-gray-200 lg:block">
            <div class="flex flex-col h-full">
                <!-- ヘッダー -->
                <div class="flex items-center h-16 px-4 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-900">育成プログラム</span>
                </div>

                <!-- ナビゲーションメニュー -->
                <nav class="flex-1 p-4 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3 py-2 text-sm rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        ホーム
                    </a>

                    <a href="{{ route('program-checks.index') }}"
                        class="flex items-center px-3 py-2 text-sm rounded-md {{ request()->routeIs('program-checks.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M4.5 6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 011.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 011.5 2.25h1.5c1.012 0 1.867.668 2.15 1.586" />
                        </svg>
                        育成プログラム
                    </a>

                    <a href="{{ route('reviews.index') }}"
                        class="flex items-center px-3 py-2 text-sm rounded-md {{ request()->routeIs('reviews.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                        </svg>
                        振り返りシート
                    </a>

                    <a href="{{ route('daily-notes.index') }}"
                        class="flex items-center px-3 py-2 text-sm rounded-md {{ request()->routeIs('daily-notes.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        日々の振り返り
                    </a>
                </nav>

                <!-- ユーザー情報 -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->full_name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-1 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 bottom-full mb-2 w-48 rounded-lg bg-white shadow-lg ring-1 ring-gray-900/5"
                                style="display: none;">
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-50">
                                            ログアウト
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- モバイルヘッダー -->
        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">メニューを開く</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="flex-1 text-sm font-semibold text-gray-900">育成プログラム</div>
            <div class="flex items-center gap-x-4">
                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</div>
            </div>
        </div>

        <!-- メインコンテンツ -->
        <main class="lg:pl-56">
            <div class="min-h-screen max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
