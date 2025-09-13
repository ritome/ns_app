@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $dailyNote->note_date->format('Y年n月j日') }}の振り返りを編集
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                記録内容を編集します。
            </p>
        </div>

        <form method="POST" action="{{ route('daily-notes.update', $dailyNote) }}" class="bg-white shadow-sm rounded-lg p-6">
            @csrf
            @method('PUT')

            {{-- 実施内容 --}}
            <div class="mb-6">
                <label for="activities" class="block text-sm font-medium text-gray-700 mb-1">
                    実施内容 <span class="text-rose-500">*</span>
                </label>
                <textarea id="activities" name="activities" rows="5"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('activities') border-rose-300 @enderror"
                    placeholder="今日実施した看護ケアや処置、参加したカンファレンスなどを記録してください" required>{{ old('activities', $dailyNote->activities) }}</textarea>
                @error('activities')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 課題・困りごと・疑問 --}}
            <div class="mb-6">
                <label for="issues" class="block text-sm font-medium text-gray-700 mb-1">
                    課題・困りごと・疑問
                </label>
                <textarea id="issues" name="issues" rows="4"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('issues') border-rose-300 @enderror"
                    placeholder="実施中に感じた課題や困りごと、疑問に思ったことを記録してください">{{ old('issues', $dailyNote->issues) }}</textarea>
                @error('issues')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 学び・気づき --}}
            <div class="mb-6">
                <label for="learnings" class="block text-sm font-medium text-gray-700 mb-1">
                    学び・気づき
                </label>
                <textarea id="learnings" name="learnings" rows="4"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('learnings') border-rose-300 @enderror"
                    placeholder="今日の業務を通じて学んだことや気づいたことを記録してください">{{ old('learnings', $dailyNote->learnings) }}</textarea>
                @error('learnings')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 明日の目標 --}}
            <div class="mb-6">
                <label for="goals" class="block text-sm font-medium text-gray-700 mb-1">
                    明日の目標
                </label>
                <textarea id="goals" name="goals" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('goals') border-rose-300 @enderror"
                    placeholder="明日の業務で特に意識したいことや達成したい目標を記録してください">{{ old('goals', $dailyNote->goals) }}</textarea>
                @error('goals')
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
