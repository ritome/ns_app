@extends('layouts.app')

@section('content')
    <div class="py-12 px-6 sm:px-8 max-w-4xl mx-auto">
        <div class="mb-12">
            <h1 class="text-3xl font-semibold text-gray-900 mb-3">振り返りシート作成</h1>
            <p class="text-lg text-gray-600">{{ $milestone->name }}の振り返りを記録します</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="milestone_id" value="{{ $milestone->id }}">

                <!-- 期間情報 -->
                <div class="border-b border-emerald-100 bg-emerald-50/50 px-8 py-8">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <h3 class="text-xl font-medium text-emerald-900">対象期間</h3>
                            <p class="text-lg text-emerald-700">
                                {{ Auth::user()->hire_date->format('Y年n月j日') }} 〜
                                {{ Auth::user()->hire_date->addDays($milestone->days_after)->format('Y年n月j日') }}
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-emerald-100 px-6 py-2.5 text-lg font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                            {{ $milestone->name }}
                        </span>
                    </div>
                </div>

                <div class="px-8 py-8 space-y-16">
                    <!-- 自己評価 -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <div class="flex items-baseline">
                                <label for="self_review" class="block text-xl font-medium text-gray-900">
                                    自己評価
                                </label>
                                <span class="ml-2 text-base font-medium text-rose-500">*</span>
                            </div>
                            <p class="text-lg text-gray-600 leading-relaxed">この期間で学んだこと、できるようになったことを具体的に記入してください</p>
                        </div>
                        <div class="mt-2">
                            <textarea id="self_review" name="self_review" rows="6"
                                class="block w-full rounded-xl border-0 py-4 px-5 text-lg text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 @error('self_review') ring-rose-300 focus:ring-rose-500 @enderror"
                                placeholder="例：&#13;&#10;・バイタルサインの測定と記録が一人でできるようになった&#13;&#10;・清潔ケアの基本的な手順を習得し、指導を受けながら実施できた&#13;&#10;・患者さんとのコミュニケーションに自信がついてきた">{{ old('self_review') }}</textarea>
                            @error('self_review')
                                <p class="mt-3 text-base text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 課題・困ったこと -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label for="challenges" class="block text-xl font-medium text-gray-900">課題・困ったこと</label>
                            <p class="text-lg text-gray-600 leading-relaxed">現在直面している課題や、この期間で困ったことを記入してください</p>
                        </div>
                        <div class="mt-2">
                            <textarea id="challenges" name="challenges" rows="5"
                                class="block w-full rounded-xl border-0 py-4 px-5 text-lg text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600"
                                placeholder="例：&#13;&#10;・急変時の対応に不安がある&#13;&#10;・複数の業務が重なった際の優先順位付けが難しい&#13;&#10;・夜勤帯での判断に自信が持てない">{{ old('challenges') }}</textarea>
                        </div>
                    </div>

                    <!-- 次期の目標 -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label for="goals" class="block text-xl font-medium text-gray-900">次期の目標</label>
                            <p class="text-lg text-gray-600 leading-relaxed">次の期間で達成したい目標を具体的に記入してください</p>
                        </div>
                        <div class="mt-2">
                            <textarea id="goals" name="goals" rows="5"
                                class="block w-full rounded-xl border-0 py-4 px-5 text-lg text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600"
                                placeholder="例：&#13;&#10;・基本的な処置を確実に実施できるようになる&#13;&#10;・患者さんの状態変化に早めに気付けるようになる&#13;&#10;・チームメンバーとの情報共有を積極的に行う">{{ old('goals') }}</textarea>
                        </div>
                    </div>

                    <!-- その他メモ -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label for="memo" class="block text-xl font-medium text-gray-900">その他メモ</label>
                            <p class="text-lg text-gray-600 leading-relaxed">上記以外に記録しておきたいことがあれば記入してください</p>
                        </div>
                        <div class="mt-2">
                            <textarea id="memo" name="memo" rows="4"
                                class="block w-full rounded-xl border-0 py-4 px-5 text-lg text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600">{{ old('memo') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 操作ボタン -->
                <div class="border-t border-emerald-100 px-8 py-8 bg-emerald-50/50">
                    <div class="flex items-center justify-end gap-x-8">
                        <a href="{{ route('reviews.index') }}"
                            class="text-lg font-semibold text-gray-700 hover:text-gray-900">
                            キャンセル
                        </a>
                        <button type="submit"
                            class="inline-flex items-center rounded-xl bg-emerald-600 px-8 py-4 text-lg font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                            下書き保存
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
