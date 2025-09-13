@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $dailyNote->note_date->format('Y年n月j日') }}の振り返り
                    </h1>
                    <div class="mt-2 text-sm text-gray-600">
                        記録者：{{ $dailyNote->user->full_name }}
                    </div>
                </div>
                @if ($dailyNote->user_id === auth()->id() && $dailyNote->isEditable())
                    <a href="{{ route('daily-notes.edit', $dailyNote) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        編集する
                    </a>
                @endif
            </div>
        </div>

        {{-- 記録内容 --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 space-y-6">
                {{-- 実施内容 --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">実施内容</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $dailyNote->activities }}</p>
                </div>

                {{-- 課題・困りごと・疑問 --}}
                @if ($dailyNote->issues)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">課題・困りごと・疑問</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $dailyNote->issues }}</p>
                    </div>
                @endif

                {{-- 学び・気づき --}}
                @if ($dailyNote->learnings)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">学び・気づき</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $dailyNote->learnings }}</p>
                    </div>
                @endif

                {{-- 明日の目標 --}}
                @if ($dailyNote->goals)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">明日の目標</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $dailyNote->goals }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- コメント一覧 --}}
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">コメント</h2>

            {{-- コメント投稿フォーム --}}
            @unless (auth()->user()->role === 'new_nurse' && $dailyNote->user_id !== auth()->id())
                <form method="POST" action="{{ route('daily-notes.comment', $dailyNote) }}" class="mb-8">
                    @csrf
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">コメントを入力</label>
                            <textarea id="comment" name="comment" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('comment') border-rose-300 @enderror"
                                required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if (auth()->user()->role !== 'new_nurse')
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_partner_of_the_day" value="1"
                                        {{ old('is_partner_of_the_day') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">当日の担当者として記録する</span>
                                </label>
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                コメントを投稿
                            </button>
                        </div>
                    </div>
                </form>
            @endunless

            {{-- コメント表示 --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($dailyNote->comments->sortByDesc('created_at') as $comment)
                        <li class="p-6">
                            <div class="flex space-x-3">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ $comment->commenter->full_name }}</h3>
                                            @if ($comment->is_partner_of_the_day)
                                                <span
                                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                    担当者
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $comment->created_at->format('Y年n月j日 H:i') }}
                                        </p>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $comment->comment }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-center text-gray-500">
                            コメントはありません
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- 戻るボタン --}}
        <div class="mt-8 flex justify-center">
            <a href="{{ route('daily-notes.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                一覧に戻る
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 bg-rose-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
@endsection
