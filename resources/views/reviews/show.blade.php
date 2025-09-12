@extends('layouts.app')

@section('content')
    <div class="py-12 px-6 sm:px-8 max-w-5xl mx-auto">
        <div class="mb-12">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 mb-3">振り返りシート</h1>
                    <p class="text-lg text-gray-600">{{ $review->milestone->name }}の振り返り内容</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    @if ($review->isEditable())
                        <div class="flex items-center gap-x-4">
                            <a href="{{ route('reviews.edit', $review) }}"
                                class="inline-flex items-center rounded-lg border border-emerald-600 px-5 py-2.5 text-base font-semibold text-emerald-600 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                編集する
                            </a>
                            <form action="{{ route('reviews.submit', $review) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                    提出する
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ステータス -->
        <div class="mb-12 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100">
                <h2 class="text-xl font-medium text-emerald-900">ステータス</h2>
            </div>
            <div class="px-8 py-6">
                <div class="flex items-center gap-x-4">
                    <div class="flex-shrink-0">
                        @if ($review->isApproved())
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-base font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                承認済み
                            </span>
                        @elseif($review->isSubmitted())
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-base font-medium text-blue-700 ring-1 ring-inset ring-blue-600/10">
                                承認待ち
                            </span>
                        @elseif($review->isRejected())
                            <span
                                class="inline-flex items-center rounded-full bg-red-50 px-4 py-2 text-base font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                差戻し
                            </span>
                        @else
                            <span
                                class="inline-flex items-center rounded-full bg-gray-50 px-4 py-2 text-base font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                下書き
                            </span>
                        @endif
                    </div>
                    <div class="text-base text-gray-600">
                        期限：{{ $review->target_date->format('Y年n月j日') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 振り返り内容 -->
        <div class="mb-12 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100">
                <h2 class="text-xl font-medium text-emerald-900">振り返り内容</h2>
            </div>
            <div class="divide-y divide-gray-200">
                <!-- 自己評価 -->
                <div class="px-8 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">自己評価</h3>
                    <div class="text-base text-gray-600 whitespace-pre-wrap">{{ $review->self_review }}</div>
                </div>

                <!-- 課題・困ったこと -->
                @if ($review->challenges)
                    <div class="px-8 py-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">課題・困ったこと</h3>
                        <div class="text-base text-gray-600 whitespace-pre-wrap">{{ $review->challenges }}</div>
                    </div>
                @endif

                <!-- 次期の目標 -->
                @if ($review->goals)
                    <div class="px-8 py-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">次期の目標</h3>
                        <div class="text-base text-gray-600 whitespace-pre-wrap">{{ $review->goals }}</div>
                    </div>
                @endif

                <!-- その他メモ -->
                @if ($review->memo)
                    <div class="px-8 py-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">その他メモ</h3>
                        <div class="text-base text-gray-600 whitespace-pre-wrap">{{ $review->memo }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 承認履歴 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100">
                <h2 class="text-xl font-medium text-emerald-900">承認履歴</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($review->approvals as $approval)
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-base font-medium text-gray-900">{{ $approval->approver->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $approval->role }}</div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $approval->approved_at ? $approval->approved_at->format('Y年n月j日 H:i') : '未承認' }}
                            </div>
                        </div>
                        @if ($approval->comment)
                            <div class="text-base text-gray-600">{{ $approval->comment }}</div>
                        @endif
                    </div>
                @empty
                    <div class="px-8 py-6 text-base text-gray-600">
                        承認履歴はありません
                    </div>
                @endforelse

                @if ($review->isApprovable())
                    <div class="px-8 py-6 bg-gray-50">
                        <form action="{{ route('reviews.approve', $review) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <label for="comment" class="block text-base font-medium text-gray-900">
                                    承認コメント
                                </label>
                                <textarea id="comment" name="comment" rows="3"
                                    class="block w-full rounded-lg border-0 py-3 px-4 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600"
                                    placeholder="承認時のコメントを入力してください"></textarea>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                        承認する
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
