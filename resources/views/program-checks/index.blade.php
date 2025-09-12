@extends('layouts.app')

@section('content')
    <div class="px-6" id="program-checks-container">
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-lg font-semibold text-slate-900">育成プログラムチェックリスト</h1>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-sm font-medium text-emerald-800">
                    必須項目
                </span>
            </div>
            <p class="text-sm text-slate-600">必須経験項目の達成状況を管理します</p>
        </div>

        <!-- カテゴリーフィルター -->
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg shadow-sm mb-6 border border-emerald-100">
            <div class="p-4 border-b border-emerald-100">
                <h2 class="text-base font-semibold text-emerald-900">カテゴリーフィルター</h2>
            </div>
            <div class="p-4 flex flex-wrap gap-2">
                <a href="{{ route('program-checks.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm {{ !$selectedCategory ? 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-200 font-medium' : 'bg-white text-slate-700 hover:bg-emerald-50 ring-1 ring-slate-200' }}">
                    全て
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('program-checks.index', ['category' => $category]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm {{ $selectedCategory === $category ? 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-200 font-medium' : 'bg-white text-slate-700 hover:bg-emerald-50 ring-1 ring-slate-200' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- チェックリスト -->
        <div class="space-y-6">
            @foreach ($items as $category => $categoryItems)
                @php
                    $total = $categoryItems->count();
                    $completed = $categoryItems
                        ->filter(fn($item) => $item->checks->first()?->checked_at !== null)
                        ->count();
                    $percentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                @endphp

                <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-200 bg-gradient-to-br from-slate-50 to-slate-100/50">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-base font-semibold text-slate-900">{{ $category }}</h2>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-sm text-emerald-700 font-medium">{{ $completed }}/{{ $total }}</span>
                                <span class="text-sm text-emerald-700 font-medium">{{ $percentage }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-white rounded-full h-2.5 p-0.5 border border-slate-200">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full transition-all duration-500"
                                style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach ($categoryItems as $item)
                            <div class="p-4 hover:bg-slate-50 transition-colors">
                                <div class="flex items-start">
                                    <form action="{{ route('program-checks.toggle', $item) }}" method="POST"
                                        class="flex-shrink-0 pt-1" data-turbo="false">
                                        @csrf
                                        <button type="submit"
                                            class="focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded p-0.5">
                                            <span class="block w-5 h-5 border-2 border-slate-400">
                                                @if ($item->checks->first()?->checked_at)
                                                    <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </button>
                                    </form>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-base font-medium text-slate-900">{{ $item->name }}</h3>
                                            @if ($item->checks->first()?->checked_at)
                                                <span class="text-sm text-emerald-700">
                                                    {{ $item->checks->first()->checked_at->format('Y年n月j日') }} 達成
                                                </span>
                                            @endif
                                        </div>
                                        @if ($item->description)
                                            <p class="mt-1 text-sm text-slate-600">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // フォーム送信時のスクロール位置を保持
            const forms = document.querySelectorAll('form[data-turbo="false"]');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    // 現在のスクロール位置をセッションストレージに保存
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                });
            });

            // ページロード時に保存されたスクロール位置を復元
            const savedScrollPosition = sessionStorage.getItem('scrollPosition');
            if (savedScrollPosition) {
                window.scrollTo(0, savedScrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        });
    </script>
@endsection
