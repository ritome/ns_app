@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">育成プログラムチェックリスト</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">カテゴリーで絞り込み</label>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('program-checks.index') }}"
                    class="inline-block px-4 py-2 rounded {{ !request('category') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                    全て
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('program-checks.index', ['category' => $category]) }}"
                        class="inline-block px-4 py-2 rounded {{ request('category') === $category ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>

        @foreach ($items as $category => $categoryItems)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ $category }}</h2>
                <div class="space-y-4">
                    @foreach ($categoryItems as $item)
                        <div class="bg-white rounded-lg shadow p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ $item->name }}</h3>
                                    @if ($item->description)
                                        <p class="text-gray-600 text-sm mt-1">{{ $item->description }}</p>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <form action="{{ route('program-checks.toggle', $item) }}" method="POST"
                                        class="flex items-center">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center justify-center w-6 h-6 rounded border {{ $item->checks->first()?->checked_at ? 'bg-green-500 border-green-600 text-white' : 'bg-white border-gray-300' }}">
                                            @if ($item->checks->first()?->checked_at)
                                                ✓
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if ($item->checks->first()?->checked_at)
                                <div class="mt-2 text-sm text-gray-500">
                                    達成日: {{ $item->checks->first()->checked_at->format('Y年n月j日') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
