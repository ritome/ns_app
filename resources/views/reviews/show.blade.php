@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 sm:px-6">
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">振り返りシート</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $review->milestone->name }}の振り返り内容を確認します</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                    {{ match ($review->status) {
                        'draft' => 'bg-gray-100 text-gray-700',
                        'submitted' => 'bg-yellow-100 text-yellow-700',
                        'in_review' => 'bg-blue-100 text-blue-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                    } }}">
                        {{ match ($review->status) {
                            'draft' => '下書き',
                            'submitted' => '提出済み',
                            'in_review' => '承認待ち',
                            'approved' => '承認済み',
                            'rejected' => '差戻し',
                        } }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- 期間情報 -->
            <div class="border-b border-gray-200 bg-gray-50/50">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-medium text-gray-900">対象期間</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $review->user->hire_date->format('Y年n月j日') }} 〜
                                {{ $review->user->hire_date->addDays($review->milestone->days_after)->format('Y年n月j日') }}
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ $review->milestone->name }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 振り返り内容 -->
            <div class="px-6 py-5 space-y-8">
                <!-- 自己評価 -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900">自己評価</h4>
                    <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $review->self_review }}</div>
                </div>

                <!-- 課題・困ったこと -->
                @if ($review->challenges)
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">課題・困ったこと</h4>
                        <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $review->challenges }}</div>
                    </div>
                @endif

                <!-- 次期の目標 -->
                @if ($review->goals)
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">次期の目標</h4>
                        <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $review->goals }}</div>
                    </div>
                @endif

                <!-- その他メモ -->
                @if ($review->memo)
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">その他メモ</h4>
                        <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $review->memo }}</div>
                    </div>
                @endif
            </div>

            <!-- 承認履歴 -->
            @if ($review->approvals->isNotEmpty())
                <div class="border-t border-gray-200 px-6 py-5">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">承認履歴</h4>
                    <div class="space-y-4">
                        @foreach ($review->approvals->sortByDesc('created_at') as $approval)
                            <div class="flex items-start gap-x-3">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full {{ $approval->status === 'approved' ? 'bg-green-50' : 'bg-red-50' }}">
                                        @if ($approval->status === 'approved')
                                            <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $approval->approver->full_name }}</span>
                                            <span
                                                class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                                {{ $approval->role }}
                                            </span>
                                        </div>
                                        <time
                                            class="text-xs text-gray-500">{{ $approval->created_at->format('Y/m/d H:i') }}</time>
                                    </div>
                                    @if ($approval->comment)
                                        <p class="mt-1 text-sm text-gray-700">{{ $approval->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 操作ボタン -->
            <div class="border-t border-gray-200 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-x-3">
                        <a href="{{ route('reviews.index') }}"
                            class="text-sm font-semibold text-gray-900 hover:text-gray-700">
                            一覧に戻る
                        </a>
                    </div>
                    <div class="flex items-center gap-x-3">
                        @if ($review->isEditable())
                            <button type="button"
                                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                編集する
                            </button>
                            <form action="{{ route('reviews.submit', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                    提出する
                                </button>
                            </form>
                        @endif

                        @if (
                            $review->isApprovable() &&
                                in_array(Auth::user()->role, ['chief', 'manager_safety', 'manager_infection', 'manager_hrd', 'director']))
                            <form action="{{ route('reviews.approve', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                    承認する
                                </button>
                            </form>
                            <button type="button"
                                class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                差し戻す
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
