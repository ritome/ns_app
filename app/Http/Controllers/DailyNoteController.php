<?php

namespace App\Http\Controllers;

use App\Models\DailyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyNoteController extends Controller
{
    /**
     * 日々の振り返り一覧を表示
     */
    public function index()
    {
        $dailyNotes = DailyNote::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('daily-notes.index', compact('dailyNotes'));
    }

    /**
     * 新規作成フォームを表示
     */
    public function create()
    {
        return view('daily-notes.create');
    }

    /**
     * 日々の振り返りを保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],
            'issues' => ['nullable', 'string'],
        ], [], [
            'date' => '日付',
            'content' => '実施内容',
            'issues' => '困りごと・疑問・課題',
        ]);

        $dailyNote = new DailyNote();
        $dailyNote->user_id = Auth::id();
        $dailyNote->date = $validated['date'];
        $dailyNote->content = $validated['content'];
        $dailyNote->issues = $validated['issues'];
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
        $this->authorize('view', $dailyNote);

        $dailyNote->load('comments.commenter');

        return view('daily-notes.show', compact('dailyNote'));
    }

    /**
     * 編集フォームを表示
     */
    public function edit(DailyNote $dailyNote)
    {
        $this->authorize('update', $dailyNote);

        return view('daily-notes.edit', compact('dailyNote'));
    }

    /**
     * 日々の振り返りを更新
     */
    public function update(Request $request, DailyNote $dailyNote)
    {
        $this->authorize('update', $dailyNote);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],
            'issues' => ['nullable', 'string'],
        ], [], [
            'date' => '日付',
            'content' => '実施内容',
            'issues' => '困りごと・疑問・課題',
        ]);

        $dailyNote->update($validated);

        return redirect()
            ->route('daily-notes.show', $dailyNote)
            ->with('success', '日々の振り返りを更新しました');
    }
}
