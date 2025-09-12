@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 sm:px-6">
        <!-- ステータスサマリー -->
        <div class="mb-8">
            <h1 class="text-xl font-semibold text-gray-900">{{ Auth::user()->full_name }} さん</h1>
            <p class="mt-1 text-sm text-gray-600">入職から {{ Auth::user()->hire_date->diffInDays(now()) }} 日目</p>
        </div>

        <!-- プログレスカード -->
        <div class="mb-12 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-base font-medium text-gray-900">育成プログラムの進捗</h2>
                        <p class="mt-1 text-sm text-gray-500">必須経験項目の達成状況</p>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                        25% 完了
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="font-medium text-gray-900">基本ケア</span>
                            <span class="text-gray-500">8/10 完了</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 80%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="font-medium text-gray-900">医療安全</span>
                            <span class="text-gray-500">3/8 完了</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 37.5%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="font-medium text-gray-900">感染対策</span>
                            <span class="text-gray-500">2/6 完了</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 33.3%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('program-checks.index') }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        詳しく見る
                        <svg class="ml-1 w-4 h-4" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- アクションカード -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- 次の予定 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-base font-medium text-gray-900 mb-4">次の予定</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">1ヶ月目振り返り</p>
                            <p class="mt-1 text-xs text-gray-500">8月17日（木）まで</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-50">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">医療安全研修</p>
                            <p class="mt-1 text-xs text-gray-500">8月21日（月）10:00-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 最近の記録 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-medium text-gray-900">最近の記録</h2>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500">すべて見る</a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">日々の振り返りを記録しました</p>
                            <p class="mt-1 text-xs text-gray-500">2時間前</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">清潔ケアの研修を完了しました</p>
                            <p class="mt-1 text-xs text-gray-500">昨日</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
