@extends('layouts.app')

@section('content')
    <div class="py-12 px-6 sm:px-8 max-w-7xl mx-auto">
        <!-- 看護職員情報 -->
        <div class="mb-12">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100">
                    <h2 class="text-xl font-medium text-emerald-900">看護職員情報</h2>
                </div>
                <div class="px-8 py-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">職員ID</div>
                            <div class="mt-1 text-lg font-medium text-gray-900">{{ Auth::user()->employee_id }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">氏名</div>
                            <div class="mt-1 text-lg font-medium text-gray-900">{{ Auth::user()->full_name }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">役職</div>
                            <div class="mt-1 text-lg font-medium text-gray-900">
                                @switch(Auth::user()->role)
                                    @case('new_nurse')
                                        新入看護職員
                                    @break

                                    @case('partner_nurse')
                                        パートナー看護師
                                    @break

                                    @case('educator')
                                        教育係
                                    @break

                                    @case('chief')
                                        主任
                                    @break

                                    @case('manager_safety')
                                        課長（医療安全）
                                    @break

                                    @case('manager_infection')
                                        課長（感染制御）
                                    @break

                                    @case('manager_hrd')
                                        課長（人材育成）
                                    @break

                                    @case('director')
                                        部長
                                    @break

                                    @default
                                        {{ Auth::user()->role }}
                                @endswitch
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">入職日</div>
                            <div class="mt-1 text-lg font-medium text-gray-900">
                                {{ Auth::user()->hire_date->format('Y年n月j日') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- メニュー -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- 育成プログラム -->
            <a href="{{ route('program-checks.index') }}" class="block">
                <div
                    class="h-full bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:bg-gray-50/50 transition-colors">
                    <div class="px-8 py-6 bg-indigo-50/50 border-b border-indigo-100">
                        <div class="flex items-center gap-x-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <h2 class="text-xl font-medium text-indigo-900">育成プログラム</h2>
                        </div>
                    </div>
                    <div class="px-8 py-6">
                        <p class="text-base text-gray-600">必須経験項目のチェックリストで、あなたの成長を可視化します。</p>
                    </div>
                </div>
            </a>

            <!-- 振り返りシート -->
            <a href="{{ route('reviews.index') }}" class="block">
                <div
                    class="h-full bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:bg-gray-50/50 transition-colors">
                    <div class="px-8 py-6 bg-pink-50/50 border-b border-pink-100">
                        <div class="flex items-center gap-x-3">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <h2 class="text-xl font-medium text-pink-900">振り返りシート</h2>
                        </div>
                    </div>
                    <div class="px-8 py-6">
                        <p class="text-base text-gray-600">節目ごとの振り返りを記録し、上司からのフィードバックを受けられます。</p>
                    </div>
                </div>
            </a>

            <!-- 日々の振り返り -->
            <a href="{{ route('daily-notes.index') }}" class="block">
                <div
                    class="h-full bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:bg-gray-50/50 transition-colors">
                    <div class="px-8 py-6 bg-teal-50/50 border-b border-teal-100">
                        <div class="flex items-center gap-x-3">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h2 class="text-xl font-medium text-teal-900">日々の振り返り</h2>
                        </div>
                    </div>
                    <div class="px-8 py-6">
                        <p class="text-base text-gray-600">毎日の実施内容や気づきを記録し、指導者からのコメントを受けられます。</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- 最近の活動 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 bg-gray-50/50 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">最近の活動</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse([] as $activity)
                    <div class="px-8 py-6">
                        <div class="text-base text-gray-900">{{ $activity->description }}</div>
                        <div class="mt-1 text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="px-8 py-6 text-base text-gray-600">
                        最近の活動はありません
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
