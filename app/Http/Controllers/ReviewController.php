<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * 振り返りシート一覧を表示
     */
    public function index()
    {
        // マイルストーン一覧を取得（関連するレビューも含めて）
        $milestones = Milestone::with(['review' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->orderBy('days_after')->get();

        // 次に作成すべきマイルストーンを特定
        $nextMilestone = $milestones->first(function ($milestone) {
            return !$milestone->hasReview();
        });

        // 完了率を計算（作成済み / 全体）
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->filter(function ($milestone) {
            return $milestone->hasReview();
        })->count();

        $completionRate = $totalMilestones > 0
            ? round(($completedMilestones / $totalMilestones) * 100)
            : 0;

        // 承認率を計算（承認済み / 作成済み）
        $approvedMilestones = $milestones->filter(function ($milestone) {
            return $milestone->hasReview() && $milestone->review->isApproved();
        })->count();

        $approvalRate = $completedMilestones > 0
            ? round(($approvedMilestones / $completedMilestones) * 100)
            : 0;

        return view('reviews.index', compact(
            'milestones',
            'nextMilestone',
            'completionRate',
            'approvalRate'
        ));
    }

    /**
     * 新規作成フォームを表示
     */
    public function create(Request $request)
    {
        $milestone = Milestone::findOrFail($request->milestone_id);

        // すでにレビューが存在する場合は編集画面にリダイレクト
        if ($milestone->hasReview()) {
            return redirect()->route('reviews.edit', $milestone->review);
        }

        return view('reviews.create', compact('milestone'));
    }

    /**
     * 振り返りシートを保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'milestone_id' => ['required', 'exists:milestones,id'],
            'self_review' => ['required', 'string', 'min:10'],
            'challenges' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
            'memo' => ['nullable', 'string'],
        ], [], [
            'self_review' => '自己評価',
            'challenges' => '課題・困ったこと',
            'goals' => '次期の目標',
            'memo' => 'その他メモ',
        ]);

        $milestone = Milestone::findOrFail($validated['milestone_id']);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->milestone_id = $validated['milestone_id'];
        $review->self_review = $validated['self_review'];
        $review->challenges = $validated['challenges'];
        $review->goals = $validated['goals'];
        $review->memo = $validated['memo'];
        $review->status = Review::STATUS_DRAFT;

        // target_dateを入職日からの日数で計算
        $review->target_date = Auth::user()->hire_date->addDays($milestone->days_after);

        $review->save();

        return redirect()
            ->route('reviews.show', $review)
            ->with('success', '振り返りシートを保存しました');
    }

    /**
     * 振り返りシートの詳細を表示
     */
    public function show(Review $review)
    {
        // 権限チェック（自分のレビューまたは承認者のみアクセス可能）
        $this->authorize('view', $review);

        $review->load(['milestone', 'approvals.approver']);

        return view('reviews.show', compact('review'));
    }

    /**
     * 編集フォームを表示
     */
    public function edit(Review $review)
    {
        // 権限チェック（自分のレビューのみ編集可能）
        $this->authorize('update', $review);

        // 承認済みの場合は編集不可
        if ($review->isApproved()) {
            return redirect()
                ->route('reviews.show', $review)
                ->with('error', '承認済みの振り返りシートは編集できません');
        }

        $review->load('milestone');

        return view('reviews.edit', compact('review'));
    }

    /**
     * 振り返りシートを更新
     */
    public function update(Request $request, Review $review)
    {
        // 権限チェック
        $this->authorize('update', $review);

        // 承認済みの場合は編集不可
        if ($review->isApproved()) {
            return redirect()
                ->route('reviews.show', $review)
                ->with('error', '承認済みの振り返りシートは編集できません');
        }

        $validated = $request->validate([
            'self_review' => ['required', 'string', 'min:10'],
            'challenges' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
            'memo' => ['nullable', 'string'],
        ], [], [
            'self_review' => '自己評価',
            'challenges' => '課題・困ったこと',
            'goals' => '次期の目標',
            'memo' => 'その他メモ',
        ]);

        $review->update($validated);

        return redirect()
            ->route('reviews.show', $review)
            ->with('success', '振り返りシートを更新しました');
    }

    /**
     * レビューを提出（承認待ち状態に）
     */
    public function submit(Review $review)
    {
        // 権限チェック
        $this->authorize('submit', $review);

        if ($review->isSubmitted() || $review->isApproved()) {
            return redirect()
                ->route('reviews.show', $review)
                ->with('error', 'すでに提出済みです');
        }

        $review->status = Review::STATUS_SUBMITTED;
        $review->submitted_at = now();
        $review->save();

        // TODO: 承認者への通知

        return redirect()
            ->route('reviews.show', $review)
            ->with('success', '振り返りシートを提出しました');
    }

    /**
     * レビューを承認
     */
    public function approve(Request $request, Review $review)
    {
        // 権限チェック
        $this->authorize('approve', $review);

        $validated = $request->validate([
            'comment' => ['nullable', 'string'],
        ], [], [
            'comment' => '承認コメント',
        ]);

        try {
            $review->approve(Auth::user(), $validated['comment'] ?? null);
        } catch (\Exception $e) {
            return redirect()
                ->route('reviews.show', $review)
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('reviews.show', $review)
            ->with('success', '振り返りシートを承認しました');
    }

    /**
     * レビューを差戻し
     */
    public function reject(Request $request, Review $review)
    {
        // 権限チェック
        $this->authorize('approve', $review);

        $validated = $request->validate([
            'comment' => ['required', 'string'],
        ], [], [
            'comment' => '差戻しコメント',
        ]);

        try {
            $review->reject(Auth::user(), $validated['comment']);
        } catch (\Exception $e) {
            return redirect()
                ->route('reviews.show', $review)
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('reviews.show', $review)
            ->with('success', '振り返りシートを差戻ししました');
    }
}
