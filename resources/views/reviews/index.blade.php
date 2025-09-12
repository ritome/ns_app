@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-xl font-semibold text-gray-900">振り返りシート</h1>
            <p class="mt-1 text-sm text-gray-500">節目ごとの振り返りと承認を管理します</p>
        </div>

        <!-- マイルストーンタイムライン -->
        <div class="mb-12">
            <div class="relative">
                <!-- タイムライン線 -->
                <div class="absolute top-5 left-5 h-full w-0.5 bg-gray-200"></div>

                <!-- マイルストーン一覧 -->
                <div class="space-y-8">
                    @foreach ($milestones as $milestone)
                        @php
                            $review = $reviews->get($milestone->id);
                            $status = $review?->status ?? 'pending';
                            $statusColor = match ($status) {
                                'draft' => 'bg-gray-100 text-gray-700',
                                'submitted' => 'bg-yellow-100 text-yellow-700',
                                'in_review' => 'bg-blue-100 text-blue-700',
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <div class="relative pl-12">
                            <!-- マイルストーンポイント -->
                            <div
                                class="absolute top-1 left-4 w-3 h-3 rounded-full border-2 {{ $status === 'approved' ? 'bg-green-500 border-green-500' : 'bg-white border-gray-300' }}">
                            </div>

                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-base font-medium text-gray-900">{{ $milestone->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ Auth::user()->hire_date->addDays($milestone->days_after)->format('Y年n月j日') }}まで
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColor }}">
                                        {{ match ($status) {
                                            'draft' => '下書き',
                                            'submitted' => '提出済み',
                                            'in_review' => '承認待ち',
                                            'approved' => '承認済み',
                                            'rejected' => '差戻し',
                                            default => '未作成',
                                        } }}
                                    </span>
                                </div>

                                @if ($review)
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            @foreach ($review->approvals->where('status', 'approved') as $approval)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                    {{ $approval->role }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <a href="{{ route('reviews.show', $review) }}"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                            詳細を見る
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <a href="{{ route('reviews.create', ['milestone_id' => $milestone->id]) }}"
                                            class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                                            作成する
                                            <svg class="ml-1 w-4 h-4" viewBox="0 0 16 16" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
