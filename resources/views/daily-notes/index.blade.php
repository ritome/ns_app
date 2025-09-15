@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold text-gray-900">日々の振り返り</h1>
                <p class="mt-2 text-sm text-gray-700">
                    @if (auth()->user()->role === 'new_nurse')
                        毎日の業務内容や学びを記録します
                    @else
                        新入看護師の日々の振り返りを確認できます
                    @endif
                </p>
            </div>
            @if (auth()->user()->role === 'new_nurse')
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('daily-notes.create') }}"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto">
                        新規作成
                    </a>
                </div>
            @endif
        </div>

        {{-- フィルター --}}
        @unless (auth()->user()->role === 'new_nurse')
            <form method="GET" action="{{ route('daily-notes.index') }}" class="mt-8 sm:flex sm:gap-4">
                <div class="sm:flex-1">
                    <label for="nurse_id" class="block text-sm font-medium text-gray-700">新入看護師</label>
                    <select id="nurse_id" name="nurse_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">全員</option>
                        @foreach ($nurses ?? [] as $nurse)
                            <option value="{{ $nurse->id }}" @selected(request('nurse_id') == $nurse->id)>
                                {{ $nurse->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 sm:mt-0 sm:flex-1">
                    <label for="period" class="block text-sm font-medium text-gray-700">期間</label>
                    <select id="period" name="period"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">全期間</option>
                        <option value="today" @selected(request('period') === 'today')>今日</option>
                        <option value="week" @selected(request('period') === 'week')>1週間以内</option>
                        <option value="month" @selected(request('period') === 'month')>1ヶ月以内</option>
                    </select>
                </div>

                <div class="mt-4 sm:mt-0 sm:flex-none sm:self-end">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto">
                        検索
                    </button>
                </div>
            </form>
        @endunless

        {{-- 一覧 --}}
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        日付
                                    </th>
                                    @unless (auth()->user()->role === 'new_nurse')
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            新入看護師
                                        </th>
                                    @endunless
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        実施内容
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        担当者コメント
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">操作</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($dailyNotes as $dailyNote)
                                    <tr>
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ $dailyNote->note_date->format('Y年n月j日') }}
                                        </td>
                                        @unless (auth()->user()->role === 'new_nurse')
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $dailyNote->user->full_name }}
                                            </td>
                                        @endunless
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            <div class="line-clamp-2">
                                                {{ $dailyNote->activities }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            @if ($partnerComment = $dailyNote->partnerComment())
                                                <div class="line-clamp-2">
                                                    {{ $partnerComment->comment }}
                                                    <span class="text-xs text-gray-400">
                                                        ({{ $partnerComment->commenter->full_name }})
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-gray-400">未記入</span>
                                            @endif
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ route('daily-notes.show', $dailyNote) }}"
                                                class="text-emerald-600 hover:text-emerald-900">
                                                詳細
                                                <span class="sr-only">, {{ $dailyNote->note_date->format('Y年n月j日') }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-4 text-sm text-gray-500 text-center">
                                            記録がありません
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ページネーション --}}
        @if ($dailyNotes->hasPages())
            <div class="mt-4">
                {{ $dailyNotes->links() }}
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
@endsection
