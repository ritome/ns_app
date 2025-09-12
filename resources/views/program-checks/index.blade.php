@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">育成プログラムチェックリスト</h1>
            <p class="text-gray-600">必須経験項目の達成状況を管理します</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="font-semibold text-gray-800">カテゴリーフィルター</h2>
            </div>
            <div class="p-4 flex flex-wrap gap-2">
                <a href="{{ route('program-checks.index') }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-md {{ !request('category') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    全て
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('program-checks.index', ['category' => $category]) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-md {{ request('category') === $category ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid gap-6">
            @foreach ($items as $category => $categoryItems)
                @php
                    $totalItems = $categoryItems->count();
                    $completedItems = $categoryItems
                        ->filter(function ($item) {
                            return $item->checks->first()?->checked_at !== null;
                        })
                        ->count();
                    $progressPercentage = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;
                @endphp

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="font-semibold text-gray-800">{{ $category }}</h2>
                            <span class="text-sm text-gray-600">達成率: {{ number_format($progressPercentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <div class="mt-1 text-sm text-gray-600">
                            {{ $completedItems }}/{{ $totalItems }} 項目完了
                        </div>
                    </div>

                    <div class="divide-y">
                        @foreach ($categoryItems as $item)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <form action="{{ route('program-checks.toggle', $item) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="w-6 h-6 border-2 rounded flex items-center justify-center transition-colors duration-200 
                                            {{ $item->checks->first()?->checked_at
                                                ? 'bg-blue-500 border-blue-500 hover:bg-blue-600 hover:border-blue-600'
                                                : 'border-gray-300 hover:border-blue-500' }}">
                                                @if ($item->checks->first()?->checked_at)
                                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-medium text-gray-800">{{ $item->name }}</h3>
                                            @if ($item->checks->first()?->checked_at)
                                                <span class="text-sm text-green-600">
                                                    {{ $item->checks->first()->checked_at->format('Y年n月j日') }} 達成
                                                </span>
                                            @endif
                                        </div>
                                        @if ($item->description)
                                            <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
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
@endsection
