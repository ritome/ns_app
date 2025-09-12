@extends('layouts.app')

@section('content')
    <div class="py-12 px-6 sm:px-8 max-w-5xl mx-auto">
        <div class="mb-12">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 mb-3">振り返りシート</h1>
                    <p class="text-lg text-gray-600">入職日からの節目で振り返りを行い、成長を記録します</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('reviews.create', ['milestone_id' => $nextMilestone->id]) }}"
                        class="inline-flex items-center rounded-xl bg-emerald-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        新規作成
                    </a>
                </div>
            </div>
        </div>

        <!-- 進捗状況 -->
        <div class="mb-12 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100">
                <h2 class="text-xl font-medium text-emerald-900">振り返り進捗状況</h2>
            </div>
            <div class="px-8 py-6">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-24 text-base font-medium text-gray-500">完了</div>
                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $completionRate }}%"></div>
                        </div>
                        <div class="flex-shrink-0 w-16 text-base font-medium text-emerald-600">{{ $completionRate }}%</div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-24 text-base font-medium text-gray-500">承認済み</div>
                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $approvalRate }}%"></div>
                        </div>
                        <div class="flex-shrink-0 w-16 text-base font-medium text-blue-600">{{ $approvalRate }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 振り返り一覧 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden divide-y divide-gray-200">
            @foreach ($milestones as $milestone)
                <div class="group">
                    <div class="px-8 py-6 hover:bg-gray-50/50">
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <div class="mb-4 sm:mb-0">
                                <div class="flex items-center gap-x-3">
                                    <span class="text-lg font-medium text-gray-900">{{ $milestone->name }}</span>
                                    @if ($milestone->hasReview())
                                        @if ($milestone->review->isApproved())
                                            <span
                                                class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-base font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">承認済み</span>
                                        @elseif($milestone->review->isSubmitted())
                                            <span
                                                class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-base font-medium text-blue-700 ring-1 ring-inset ring-blue-600/10">承認待ち</span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-gray-50 px-3 py-1 text-base font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">下書き</span>
                                        @endif
                                    @endif
                                </div>
                                <p class="mt-2 text-base text-gray-600">
                                    期限：{{ Auth::user()->hire_date->addDays($milestone->days_after)->format('Y年n月j日') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-x-4">
                                @if ($milestone->hasReview())
                                    <a href="{{ route('reviews.show', $milestone->review) }}"
                                        class="inline-flex items-center rounded-lg px-5 py-2.5 text-base font-semibold text-emerald-600 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                        詳細を見る
                                    </a>
                                @else
                                    <a href="{{ route('reviews.create', ['milestone_id' => $milestone->id]) }}"
                                        class="inline-flex items-center rounded-lg border border-emerald-600 px-5 py-2.5 text-base font-semibold text-emerald-600 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                        作成する
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
