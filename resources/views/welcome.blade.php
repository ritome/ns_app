<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StepNurse - 新入看護職員育成プログラム</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=noto-sans-jp:400,500,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-4xl mx-auto text-center">
        <!-- ロゴ -->
        <h1 class="text-3xl font-bold text-teal-600 mb-2">StepNurse</h1>
        <p class="text-xl text-gray-600 mb-12">新入看護職員育成プログラム</p>

        <!-- イラスト -->
        <div class="mb-12">
            <div class="max-w-[320px] mx-auto">
                <img src="{{ asset('images/nurse-hero.png') }}" alt="看護師のイラスト" class="w-full h-auto">
            </div>
        </div>

        <!-- ボタン -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-teal-600 text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-teal-700 transition-colors">
                        ダッシュボード
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-white text-teal-600 px-8 py-3 rounded-md text-lg font-medium border-2 border-teal-600 hover:bg-teal-50 transition-colors">
                        ログイン
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-teal-600 text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-teal-700 transition-colors">
                            新規登録
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>

</html>
