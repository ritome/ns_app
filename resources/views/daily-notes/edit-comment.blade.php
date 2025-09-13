@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">コメントを編集</h1>
            <p class="mt-2 text-sm text-gray-600">
                {{ $dailyNote->note_date->format('Y年n月j日') }}の振り返りへのコメントを編集します。
            </p>
        </div>

        <form method="POST" action="{{ route('daily-notes.comments.update', [$dailyNote, $comment]) }}"
            class="bg-white shadow-sm rounded-lg p-6">
            @csrf
            @method('PUT')

            {{-- コメント本文 --}}
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                    コメント <span class="text-rose-500">*</span>
                </label>
                <textarea id="comment" name="comment" rows="4"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('comment') border-rose-300 @enderror"
                    required>{{ old('comment', $comment->comment) }}</textarea>
                @error('comment')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 担当者区分 --}}
            <div class="mb-6">
                <div class="text-sm font-medium text-gray-700 mb-2">担当者区分 <span class="text-rose-500">*</span></div>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_partner_of_the_day" value="1"
                            {{ old('is_partner_of_the_day', $comment->is_partner_of_the_day) ? 'checked' : '' }}
                            class="rounded-full border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50"
                            required>
                        <span class="ml-2 text-sm text-gray-600">当日の担当者</span>
                    </label>
                    <br>
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_partner_of_the_day" value="0"
                            {{ old('is_partner_of_the_day', $comment->is_partner_of_the_day) ? '' : 'checked' }}
                            class="rounded-full border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50"
                            required>
                        <span class="ml-2 text-sm text-gray-600">その他の指導者</span>
                    </label>
                </div>
                @error('is_partner_of_the_day')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('daily-notes.show', $dailyNote) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    キャンセル
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    更新する
                </button>
            </div>
        </form>
    </div>
@endsection
