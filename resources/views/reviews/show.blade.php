@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $review->milestone->name }}の振り返り
            </h1>
            <p class="text-sm text-gray-600">
                対象期間: {{ $review->target_date->format('Y年n月j日') }}
            </p>
        </div>

        {{-- ステータスと進捗バー --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span
                        class="px-3 py-1 text-sm rounded-full bg-{{ $review->getStatusColor() }}-100 text-{{ $review->getStatusColor() }}-800">
                        {{ $review->getStatusLabel() }}
                    </span>
                    @if ($review->submitted_at)
                        <span class="text-sm text-gray-500">
                            提出日: {{ $review->submitted_at->format('Y年n月j日 H:i') }}
                        </span>
                    @endif
                </div>
                <div class="text-sm text-gray-500">
                    承認進捗: {{ $review->getApprovalProgressPercentage() }}%
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                @if ($review->status !== 'draft')
                    <div class="bg-{{ $review->getStatusColor() }}-500 h-2 rounded-full transition-all duration-300"
                        style="width: {{ $review->getApprovalProgressPercentage() }}%">
                    </div>
                @endif
            </div>
        </div>

        {{-- レビュー内容 --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">自己評価</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $review->self_review }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">課題・疑問点</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $review->challenges }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">今後の目標</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $review->goals }}</p>
                </div>
                @if ($review->memo)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">メモ</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $review->memo }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- 承認履歴 --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">承認履歴</h3>
            <div class="space-y-4">
                @foreach ($review->approvals->sortByDesc('created_at') as $approval)
                    <div class="flex items-start space-x-4 p-4 {{ $loop->first ? '' : 'border-t' }}">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $approval->approver->full_name }}</span>
                                    <span class="text-sm text-gray-500">（{{ $approval->getRoleName() }}）</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ ($approval->approved_at ?? $approval->rejected_at)->format('Y年n月j日 H:i') }}
                                </div>
                            </div>
                            @if ($approval->comment)
                                <p class="mt-2 text-gray-700">{{ $approval->comment }}</p>
                            @endif
                            <div class="mt-1">
                                @if ($approval->isApproved())
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800">
                                        承認
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-rose-100 text-rose-800">
                                        差戻し
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($review->approvals->isEmpty())
                    <p class="text-gray-500 text-center py-4">承認履歴はありません</p>
                @endif
            </div>
        </div>

        {{-- アクションボタン --}}
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="{{ route('reviews.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    一覧に戻る
                </a>
                @if ($review->isEditable() && $review->user_id === auth()->id())
                    <a href="{{ route('reviews.edit', $review) }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        編集する
                    </a>
                @endif
            </div>

            @if ($review->user_id === auth()->id() && $review->status === 'draft')
                <form action="{{ route('reviews.submit', $review) }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                        onclick="return confirm('提出してよろしいですか？')">
                        提出する
                    </button>
                </form>
            @endif

            @if ($review->isApprovable())
                <div class="flex space-x-4">
                    {{-- 承認ボタン --}}
                    <form action="{{ route('reviews.approve', $review) }}" method="POST">
                        @csrf
                        <div x-data="{ showModal: false, comment: '' }" class="inline-block">
                            <button type="button" @click="showModal = true"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                承認する
                            </button>

                            {{-- 承認モーダル --}}
                            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div
                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                        @click="showModal = false" aria-hidden="true"></div>

                                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4"
                                                        id="modal-title">
                                                        承認コメント
                                                    </h3>
                                                    <div class="mt-2">
                                                        <textarea x-model="comment" name="comment" rows="4"
                                                            class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                            placeholder="コメントを入力（任意）"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                承認する
                                            </button>
                                            <button type="button" @click="showModal = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                キャンセル
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- 差戻しボタン --}}
                    <form action="{{ route('reviews.reject', $review) }}" method="POST">
                        @csrf
                        <div x-data="{ showModal: false, comment: '' }" class="inline-block">
                            <button type="button" @click="showModal = true"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                差戻す
                            </button>

                            {{-- 差戻しモーダル --}}
                            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div
                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                        @click="showModal = false" aria-hidden="true"></div>

                                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4"
                                                        id="modal-title">
                                                        差戻しコメント
                                                    </h3>
                                                    <div class="mt-2">
                                                        <textarea x-model="comment" name="comment" rows="4"
                                                            class="shadow-sm focus:ring-rose-500 focus:border-rose-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                            placeholder="差戻しの理由を入力してください" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-medium text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                差戻す
                                            </button>
                                            <button type="button" @click="showModal = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                キャンセル
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('modal', () => ({
                    showModal: false,
                    comment: '',
                }))
            })
        </script>
    @endpush
@endsection
