<div class="container mx-auto px-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">育成プログラムチェックリスト</h1>
        <p class="text-gray-600 mt-1">必須経験項目の達成状況を管理します</p>
    </div>

    <!-- カテゴリーフィルター -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="p-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">カテゴリーフィルター</h2>
        </div>
        <div class="p-4 flex flex-wrap gap-2">
            <button type="button" wire:click="selectCategory(null)"
                class="px-3 py-1.5 rounded-md {{ !$selectedCategory ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                全て
            </button>
            @foreach ($categories as $category)
                <button type="button" wire:click="selectCategory('{{ $category }}')"
                    class="px-3 py-1.5 rounded-md {{ $selectedCategory === $category ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- チェックリスト -->
    <div class="space-y-6">
        @foreach ($items as $category => $categoryItems)
            @php
                $stats = $this->getProgressStats($categoryItems);
            @endphp

            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="font-semibold text-gray-800">{{ $category }}</h2>
                        <span class="text-sm text-gray-600">達成率: {{ $stats['percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500"
                            style="width: {{ $stats['percentage'] }}%">
                        </div>
                    </div>
                    <div class="mt-1 text-sm text-gray-600">
                        {{ $stats['completed'] }}/{{ $stats['total'] }} 項目完了
                    </div>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach ($categoryItems as $item)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <button type="button" wire:click="toggleCheck({{ $item->id }})"
                                        class="w-5 h-5 border-2 rounded transition-colors duration-200 
                                                {{ $item->checks->first()?->checked_at
                                                    ? 'bg-blue-500 border-blue-500'
                                                    : 'border-gray-300 hover:border-blue-500' }}">
                                        @if ($item->checks->first()?->checked_at)
                                            <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-800">{{ $item->name }}</h3>
                                        @if ($item->checks->first()?->checked_at)
                                            <span class="text-xs text-green-600">
                                                {{ $item->checks->first()->checked_at->format('Y年n月j日') }} 達成
                                            </span>
                                        @endif
                                    </div>
                                    @if ($item->description)
                                        <p class="text-xs text-gray-600 mt-1">{{ $item->description }}</p>
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
