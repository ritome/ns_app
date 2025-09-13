<?php

namespace App\Http\Controllers;

use App\Models\ProgramItem;
use App\Models\ProgramCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProgramCheckController extends Controller
{
    /**
     * 承認者用のチェックリスト一覧を表示
     */
    public function approverIndex(Request $request)
    {
        // 新入看護師一覧を取得
        $newNurses = User::where('role', 'new_nurse')
            ->orderBy('hire_date')
            ->get();

        return view('program-checks.approver.index', compact('newNurses'));
    }

    /**
     * 承認者用の特定の新人のチェックリスト詳細を表示
     */
    public function approverShow(Request $request, User $user)
    {
        // 新入看護師以外のチェックリストは表示不可
        if ($user->role !== 'new_nurse') {
            abort(404);
        }

        // クエリの構築
        $query = ProgramItem::with(['checks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        // カテゴリーでフィルター
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // チェックリスト項目を取得（新人用と同じ順序で）
        $items = $query->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // 進捗率を計算
        $totalCount = $items->count();
        $checkedCount = $items->filter(function ($item) {
            return $item->checks->isNotEmpty() && $item->checks->first()->checked_at !== null;
        })->count();

        $percentage = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;

        // カテゴリー一覧を取得
        $categories = ProgramItem::query()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('program-checks.approver.show', [
            'user' => $user,
            'groupedItems' => $items->groupBy('category'),
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'checkedCount' => $checkedCount,
            'totalCount' => $totalCount,
            'percentage' => $percentage,
        ]);
    }
    public function index(Request $request)
    {
        $query = ProgramItem::query()
            ->with(['checks' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $groupedItems = $items->groupBy('category');

        // チェック済みのアイテム数を計算
        $checkedCount = 0;
        foreach ($items as $item) {
            if ($item->isChecked()) {
                $checkedCount++;
            }
        }

        $totalCount = $items->count();
        $percentage = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;

        $categories = ProgramItem::query()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('program-checks.index', [
            'groupedItems' => $groupedItems,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'checkedCount' => $checkedCount,
            'totalCount' => $totalCount,
            'percentage' => $percentage,
        ]);
    }

    public function toggle(Request $request, ProgramItem $program_item)
    {
        try {
            $userId = Auth::id();
            $currentTime = now();

            \Log::info('Toggle request:', [
                'user_id' => $userId,
                'program_item_id' => $program_item->id,
                'current_time' => $currentTime->format('Y-m-d H:i:s'),
            ]);

            $check = ProgramCheck::where('user_id', $userId)
                ->where('program_item_id', $program_item->id)
                ->first();

            if ($check) {
                $check->checked_at = $check->checked_at ? null : $currentTime;
                $check->save();
            } else {
                $check = ProgramCheck::create([
                    'user_id' => $userId,
                    'program_item_id' => $program_item->id,
                    'checked_at' => $currentTime,
                ]);
            }

            $checked = $check->checked_at !== null;
            $checked_at = $checked ? $currentTime->format('Y年n月j日') : null;

            \Log::info('Toggle result:', [
                'checked' => $checked,
                'checked_at' => $checked_at,
            ]);

            // 全体の進捗を再計算
            $totalCount = ProgramItem::count();
            $checkedCount = ProgramCheck::where('user_id', Auth::id())
                ->whereNotNull('checked_at')
                ->count();
            $percentage = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;

            return response()->json([
                'checked' => $checked,
                'checked_at' => $checked_at,
                'checked_count' => $checkedCount,
                'total_count' => $totalCount,
                'percentage' => $percentage,
            ]);
        } catch (\Exception $e) {
            \Log::error('Toggle error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'チェックの更新中にエラーが発生しました。',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
