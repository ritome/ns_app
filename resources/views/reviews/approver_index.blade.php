@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">振り返りシート承認</h1>
            <p class="mt-2 text-sm text-gray-600">新入看護師の振り返りシートを確認・承認できます。</p>
        </div>

        {{-- フィルター --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('reviews.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- 新入看護師フィルター --}}
                <div>
                    <label for="nurse_id" class="block text-sm font-medium text-gray-700 mb-1">新入看護師</label>
                    <select name="nurse_id" id="nurse_id"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">全員</option>
                        @foreach ($newNurses as $nurse)
                            <option value="{{ $nurse->id }}" {{ request('nurse_id') == $nurse->id ? 'selected' : '' }}>
                                {{ $nurse->full_name }}（{{ $nurse->hire_date->format('Y年n月入職') }}）
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ステータスフィルター --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                    <select name="status" id="status"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">全て</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>承認待ち</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>承認済み</option>
                    </select>
                </div>

                {{-- 期間フィルター --}}
                <div>
                    <label for="period" class="block text-sm font-medium text-gray-700 mb-1">期間</label>
                    <select name="period" id="period"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">全期間</option>
                        <option value="1week" {{ request('period') === '1week' ? 'selected' : '' }}>1週間以内</option>
                        <option value="1month" {{ request('period') === '1month' ? 'selected' : '' }}>1ヶ月以内</option>
                        <option value="3months" {{ request('period') === '3months' ? 'selected' : '' }}>3ヶ月以内</option>
                    </select>
                </div>

                {{-- 検索ボタン --}}
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-emerald-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        検索
                    </button>
                </div>
            </form>
        </div>

        {{-- レビュー一覧 --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            新入看護師
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            節目
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            提出日
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ステータス
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            承認進捗
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">操作</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="font-medium text-gray-900">{{ $review->user->full_name }}</div>
                                <div class="text-gray-500">{{ $review->user->hire_date->format('Y年n月入職') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $review->milestone->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $review->submitted_at->format('Y年n月j日') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $review->getStatusColor() }}-100 text-{{ $review->getStatusColor() }}-800">
                                    {{ $review->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500 rounded-full"
                                            style="width: {{ $review->getApprovalProgressPercentage() }}%">
                                        </div>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">
                                        {{ $review->getApprovalProgressPercentage() }}%
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('reviews.show', $review) }}"
                                    class="text-emerald-600 hover:text-emerald-900">
                                    確認する
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                承認待ちの振り返りシートはありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーション --}}
            @if ($reviews->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
