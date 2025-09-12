@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-lg bg-white/80">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-4">マイページ</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">職員ID</p>
                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->employee_id }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">氏名</p>
                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->full_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">役職</p>
                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">入職日</p>
                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->hire_date->format('Y年n月j日') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <a href="{{ route('program-checks.index') }}"
                class="group relative overflow-hidden bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:bg-gradient-to-br hover:from-blue-50 hover:to-white">
                <div
                    class="absolute top-0 right-0 w-32 h-32 transform translate-x-16 -translate-y-16 bg-blue-100 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500">
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">育成プログラム</h3>
                <p class="text-gray-600 mb-4">必須経験項目のチェックリストです。</p>
                <div class="flex items-center text-blue-600 group-hover:translate-x-2 transition-transform duration-300">
                    <span class="font-medium">開始する</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>

            <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden opacity-75">
                <div
                    class="absolute top-0 right-0 w-32 h-32 transform translate-x-16 -translate-y-16 bg-purple-100 rounded-full opacity-20">
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">振り返りシート</h3>
                <p class="text-gray-600 mb-4">節目ごとの面談・承認を記録します。</p>
                <p class="inline-block px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-600">準備中</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden opacity-75">
                <div
                    class="absolute top-0 right-0 w-32 h-32 transform translate-x-16 -translate-y-16 bg-green-100 rounded-full opacity-20">
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">日々の振り返り</h3>
                <p class="text-gray-600 mb-4">毎日の記録とコメントを管理します。</p>
                <p class="inline-block px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-600">準備中</p>
            </div>
        </div>
    </div>
@endsection
