<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * 振り返りシート一覧を表示
     */
    public function index()
    {
        $user = Auth::user();

        // マイルストーン一覧を取得（入職日からの日数でフィルタリング）
        $milestones = Milestone::all()
            ->filter(function ($milestone) use ($user) {
                return $user->hire_date->addDays($milestone->days_after)->isPast();
            })
            ->sortBy('days_after');

        // 各マイルストーンに対応するレビューを取得
        $reviews = Review::where('user_id', $user->id)
            ->with(['milestone', 'approvals.approver'])
            ->get()
            ->keyBy('milestone_id');

        return view('reviews.index', [
            'milestones' => $milestones,
            'reviews' => $reviews,
        ]);
    }

    /**
     * 新規振り返りシートを作成
     */
    public function create(Request $request)
    {
        $milestone = Milestone::findOrFail($request->milestone_id);

        return view('reviews.create', [
            'milestone' => $milestone,
        ]);
    }

    /**
     * 振り返りシートを保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'milestone_id' => ['required', 'exists:milestones,id'],
            'self_review' => ['required', 'string'],
            'challenges' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
            'memo' => ['nullable', 'string'],
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'milestone_id' => $validated['milestone_id'],
            'target_date' => now(),
            'self_review' => $validated['self_review'],
            'challenges' => $validated['challenges'],
            'goals' => $validated['goals'],
            'memo' => $validated['memo'],
            'status' => 'draft',
        ]);

        return redirect()->route('reviews.show', $review)
            ->with('success', '振り返りシートを作成しました');
    }

    /**
     * 振り返りシートを表示
     */
    public function show(Review $review)
    {
        $review->load(['milestone', 'approvals.approver']);

        return view('reviews.show', [
            'review' => $review,
        ]);
    }

    /**
     * 振り返りシートを提出
     */
    public function submit(Review $review)
    {
        if (!$review->isEditable()) {
            return back()->with('error', 'この振り返りシートは提出できません');
        }

        $review->update(['status' => 'submitted']);

        return back()->with('success', '振り返りシートを提出しました');
    }

    /**
     * 振り返りシートを承認
     */
    public function approve(Request $request, Review $review)
    {
        if (!$review->isApprovable()) {
            return back()->with('error', 'この振り返りシートは承認できません');
        }

        $validated = $request->validate([
            'comment' => ['nullable', 'string'],
        ]);

        $review->approvals()->create([
            'approver_id' => Auth::id(),
            'role' => Auth::user()->role,
            'comment' => $validated['comment'],
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // すべての必要な承認が完了したかチェック
        $requiredRoles = ['chief', 'manager_safety', 'manager_infection', 'manager_hrd', 'director'];
        $approvedRoles = $review->approvals()
            ->where('status', 'approved')
            ->pluck('role')
            ->toArray();

        if (count(array_intersect($requiredRoles, $approvedRoles)) === count($requiredRoles)) {
            $review->update(['status' => 'approved']);
        } else {
            $review->update(['status' => 'in_review']);
        }

        return back()->with('success', '振り返りシートを承認しました');
    }

    /**
     * 振り返りシートを差し戻し
     */
    public function reject(Request $request, Review $review)
    {
        if (!$review->isApprovable()) {
            return back()->with('error', 'この振り返りシートは差し戻しできません');
        }

        $validated = $request->validate([
            'comment' => ['required', 'string'],
        ]);

        $review->approvals()->create([
            'approver_id' => Auth::id(),
            'role' => Auth::user()->role,
            'comment' => $validated['comment'],
            'status' => 'rejected',
        ]);

        $review->update(['status' => 'rejected']);

        return back()->with('success', '振り返りシートを差し戻しました');
    }
}
