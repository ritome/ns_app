@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-8">育成プログラム</h1>

                    <!-- 進捗バー -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                            <span>達成状況</span>
                            <span id="progress-text">{{ $checkedCount }}/{{ $totalCount }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-emerald-600 h-2.5 rounded-full"
                                style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <!-- カテゴリフィルター -->
                    <div class="flex flex-wrap gap-2 mb-8">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium rounded-full {{ $selectedCategory === null ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                            onclick="window.location.href='{{ route('program-checks.index') }}'">
                            すべて
                        </button>
                        @foreach ($categories as $category)
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium rounded-full {{ $selectedCategory === $category ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                onclick="window.location.href='{{ route('program-checks.index', ['category' => $category]) }}'">
                                {{ $category }}
                            </button>
                        @endforeach
                    </div>

                    <!-- チェックリスト -->
                    <div class="space-y-8">
                        @foreach ($groupedItems as $category => $items)
                            <div class="border rounded-lg overflow-hidden">
                                <h2 class="bg-emerald-50/50 px-6 py-4 text-lg font-medium text-emerald-900 border-b">
                                    {{ $category }}
                                </h2>
                                <div class="divide-y">
                                    @foreach ($items as $item)
                                        <div class="px-6 py-4 flex items-start gap-x-4">
                                            <div class="mt-1">
                                                <button type="button" onclick="toggleCheck({{ $item->id }})"
                                                    class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center {{ $item->isChecked() ? 'bg-emerald-600 border-emerald-600' : 'hover:border-emerald-600' }}"
                                                    id="check-{{ $item->id }}">
                                                    @if ($item->isChecked())
                                                        <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </div>
                                            <div class="flex-1 leading-relaxed">
                                                <p class="text-gray-900">{{ $item->name }}</p>
                                                @if ($item->description)
                                                    <p class="mt-1 text-sm text-gray-500">{{ $item->description }}</p>
                                                @endif
                                                <p class="mt-2 text-sm text-emerald-600" id="date-{{ $item->id }}"
                                                    style="{{ $item->isChecked() ? '' : 'display: none;' }}">
                                                    達成日: {{ $item->checked_at ? $item->checked_at->format('Y年n月j日') : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            async function toggleCheck(itemId) {
                try {
                    const response = await fetch(`/program-checks/toggle/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();
                    const checkButton = document.getElementById(`check-${itemId}`);
                    const dateText = document.getElementById(`date-${itemId}`);
                    const progressBar = document.getElementById('progress-bar');
                    const progressText = document.getElementById('progress-text');

                    // チェックボックスの状態を更新
                    if (data.checked) {
                        checkButton.classList.add('bg-emerald-600', 'border-emerald-600');
                        checkButton.innerHTML = `
                <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            `;
                        dateText.textContent = `達成日: ${data.checked_at}`;
                        dateText.style.display = '';
                    } else {
                        checkButton.classList.remove('bg-emerald-600', 'border-emerald-600');
                        checkButton.innerHTML = '';
                        dateText.style.display = 'none';
                    }

                    // 進捗バーを更新
                    progressBar.style.width = `${data.percentage}%`;
                    progressText.textContent = `${data.checked_count}/${data.total_count}`;

                } catch (error) {
                    console.error('Error:', error);
                    alert('エラーが発生しました。ページをリロードしてください。');
                }
            }
        </script>
    @endpush
@endsection
