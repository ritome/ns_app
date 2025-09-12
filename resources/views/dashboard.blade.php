@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">基本情報</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">職員ID</p>
                    <p class="font-semibold">{{ auth()->user()->employee_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">氏名</p>
                    <p class="font-semibold">{{ auth()->user()->full_name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">役職</p>
                    <p class="font-semibold">{{ auth()->user()->role }}</p>
                </div>
                <div>
                    <p class="text-gray-600">入職日</p>
                    <p class="font-semibold">{{ auth()->user()->hire_date->format('Y年n月j日') }}</p>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('program-checks.index') }}"
                class="block bg-white rounded-lg shadow-lg p-6 hover:bg-gray-50 transition">
                <h3 class="text-xl font-bold mb-2">育成プログラム</h3>
                <p class="text-gray-600">必須経験項目のチェックリストです。</p>
            </a>

            <div class="block bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold mb-2">振り返りシート</h3>
                <p class="text-gray-600">節目ごとの面談・承認を記録します。</p>
                <p class="text-sm text-gray-500 mt-2">※準備中</p>
            </div>

            <div class="block bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold mb-2">日々の振り返り</h3>
                <p class="text-gray-600">毎日の記録とコメントを管理します。</p>
                <p class="text-sm text-gray-500 mt-2">※準備中</p>
            </div>
        </div>
    </div>
@endsection
