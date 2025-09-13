@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-8">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $user->full_name }}さんの育成プログラム</h1>
                        <p class="text-sm text-gray-600">入職日: {{ $user->hire_date->format('Y年n月j日') }}</p>
                    </div>

                    <!-- 進捗バー -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                            <span>達成状況</span>
                            <span>{{ $checkedCount }}/{{ $totalCount }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <!-- カテゴリフィルター -->
                    <div class="flex flex-wrap gap-2 mb-8">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium rounded-full {{ $selectedCategory === null ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                            onclick="window.location.href='{{ route('program-checks.approver.show', $user) }}'">
                            すべて
                        </button>
                        @foreach ($categories as $category)
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium rounded-full {{ $selectedCategory === $category ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                onclick="window.location.href='{{ route('program-checks.approver.show', ['user' => $user, 'category' => $category]) }}'">
                                {{ $category }}
                            </button>
                        @endforeach
                    </div>

                    <!-- チェックリスト -->
                    <div class="space-y-8">
                        @foreach ($groupedItems as $category => $categoryItems)
                            <div class="border rounded-lg overflow-hidden">
                                <h2 class="bg-emerald-50/50 px-6 py-4 text-lg font-medium text-emerald-900 border-b">
                                    {{ $category }}
                                </h2>
                                <div class="divide-y">
                                    @foreach ($categoryItems as $item)
                                        <div class="px-6 py-4 flex items-start gap-x-4">
                                            <div class="mt-1">
                                                <div
                                                    class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center {{ $item->checks->isNotEmpty() && $item->checks->first()->checked_at ? 'bg-emerald-600 border-emerald-600' : '' }}">
                                                    @if ($item->checks->isNotEmpty() && $item->checks->first()->checked_at)
                                                        <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 leading-relaxed">
                                                <p class="text-gray-900">{{ $item->name }}</p>
                                                @if ($item->description)
                                                    <p class="mt-1 text-sm text-gray-500">{{ $item->description }}</p>
                                                @endif
                                                @if ($item->checks->isNotEmpty() && $item->checks->first()->checked_at)
                                                    <p class="mt-2 text-sm text-emerald-600">
                                                        達成日: {{ $item->checks->first()->checked_at->format('Y年n月j日') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- 戻るボタン -->
                    <div class="mt-8">
                        <a href="{{ route('program-checks.approver.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            一覧に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
