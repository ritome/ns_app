<?php

namespace App\Http\Controllers;

use App\Models\DailyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DailyNoteController extends Controller
{
    /**
     * 日々の振り返り一覧を表示
     */
    public function index(Request $request)
    {
        $query = DailyNote::with(['user', 'comments.commenter']);

        // 新入看護師の場合は自分の記録のみ表示
        if (Auth::user()->role === 'new_nurse') {
            $query->where('user_id', Auth::id());
        } else {
            // 承認者の場合は新入看護師の記録を表示
            $query->whereHas('user', function ($query) {
                $query->where('role', 'new_nurse');
            });

            // 新入看護師でフィルター
            if ($request->filled('nurse_id')) {
                $query->where('user_id', $request->nurse_id);
            }
        }

        // 期間でフィルター
        if ($request->filled('period')) {
            $query->where('note_date', '>=', match ($request->period) {
                'today' => now()->startOfDay(),
                'week' => now()->subWeek()->startOfDay(),
                'month' => now()->subMonth()->startOfDay(),
                default => now()->subYear()->startOfDay(),
            });
        }

        $dailyNotes = $query->orderBy('note_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('daily-notes.index', compact('dailyNotes'));
    }

    /**
     * 新規作成フォームを表示
     */
    public function create()
    {
        // 新入看護師以外はアクセス不可
        if (Auth::user()->role !== 'new_nurse') {
            abort(403);
        }

        // 今日の記録がすでにある場合は編集画面にリダイレクト
        $todaysNote = DailyNote::where('user_id', Auth::id())
            ->where('note_date', now()->toDateString())
            ->first();

        if ($todaysNote) {
            return redirect()->route('daily-notes.edit', $todaysNote);
        }

        return view('daily-notes.create');
    }

    /**
     * 日々の振り返りを保存
     */
    public function store(Request $request)
    {
        // 新入看護師以外はアクセス不可
        if (Auth::user()->role !== 'new_nurse') {
            abort(403);
        }

        $validated = $request->validate([
            'activities' => ['required', 'string'],
            'issues' => ['nullable', 'string'],
            'learnings' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
        ], [], [
            'activities' => '実施内容',
            'issues' => '課題・困りごと・疑問',
            'learnings' => '学び・気づき',
            'goals' => '明日の目標',
        ]);

        // 今日の日付で作成
        $dailyNote = new DailyNote($validated);
        $dailyNote->user_id = Auth::id();
        $dailyNote->note_date = now()->toDateString();
        $dailyNote->save();

        return redirect()
            ->route('daily-notes.show', $dailyNote)
            ->with('success', '日々の振り返りを保存しました');
    }

    /**
     * 日々の振り返りの詳細を表示
     */
    public function show(DailyNote $dailyNote)
    {
        // コメントを含めて再読み込み
        $dailyNote->load(['user', 'comments.commenter']);

        // デバッグ情報をログに出力
        Log::info('Daily note comments:', [
            'daily_note_id' => $dailyNote->id,
            'comments_count' => $dailyNote->comments->count(),
            'comments' => $dailyNote->comments->toArray()
        ]);

        return view('daily-notes.show', compact('dailyNote'));
    }

    /**
     * 編集フォームを表示
     */
    public function edit(DailyNote $dailyNote)
    {
        // 自分の記録以外は編集不可
        if ($dailyNote->user_id !== Auth::id()) {
            abort(403);
        }

        // 3日以上経過した記録は編集不可
        if (!$dailyNote->isEditable()) {
            return redirect()
                ->route('daily-notes.show', $dailyNote)
                ->with('error', '3日以上経過した記録は編集できません');
        }

        return view('daily-notes.edit', compact('dailyNote'));
    }

    /**
     * 日々の振り返りを更新
     */
    public function update(Request $request, DailyNote $dailyNote)
    {
        // 自分の記録以外は編集不可
        if ($dailyNote->user_id !== Auth::id()) {
            abort(403);
        }

        // 3日以上経過した記録は編集不可
        if (!$dailyNote->isEditable()) {
            return redirect()
                ->route('daily-notes.show', $dailyNote)
                ->with('error', '3日以上経過した記録は編集できません');
        }

        $validated = $request->validate([
            'activities' => ['required', 'string'],
            'issues' => ['nullable', 'string'],
            'learnings' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
        ], [], [
            'activities' => '実施内容',
            'issues' => '課題・困りごと・疑問',
            'learnings' => '学び・気づき',
            'goals' => '明日の目標',
        ]);

        $dailyNote->update($validated);

        return redirect()
            ->route('daily-notes.show', $dailyNote)
            ->with('success', '日々の振り返りを更新しました');
    }

    /**
     * コメントを投稿
     */
    public function comment(Request $request, DailyNote $dailyNote)
    {
        // 新入看護師は他人の記録にコメント不可
        if (Auth::user()->role === 'new_nurse' && $dailyNote->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $validated = $request->validate([
                'comment' => ['required', 'string'],
                'is_partner_of_the_day' => ['nullable', 'boolean'],
            ], [], [
                'comment' => 'コメント',
                'is_partner_of_the_day' => '担当者フラグ',
            ]);

            // コメントを作成
            $comment = $dailyNote->comments()->create([
                'commenter_id' => Auth::id(),
                'comment' => $validated['comment'],
                'is_partner_of_the_day' => $request->boolean('is_partner_of_the_day'),
            ]);

            // デバッグ情報をログに出力
            Log::info('Comment created:', [
                'daily_note_id' => $dailyNote->id,
                'comment_id' => $comment->id,
                'commenter_id' => Auth::id(),
                'comment' => $validated['comment'],
                'is_partner_of_the_day' => $request->boolean('is_partner_of_the_day')
            ]);

            return redirect()
                ->route('daily-notes.show', $dailyNote)
                ->with('success', 'コメントを投稿しました');

        } catch (\Exception $e) {
            Log::error('Comment creation failed:', [
                'error' => $e->getMessage(),
                'daily_note_id' => $dailyNote->id,
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'コメントの投稿に失敗しました: ' . $e->getMessage());
        }
    }
}