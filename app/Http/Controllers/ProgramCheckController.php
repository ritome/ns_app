<?php

namespace App\Http\Controllers;

use App\Models\ProgramItem;
use App\Models\ProgramCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramCheckController extends Controller
{
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
        $check = ProgramCheck::where('user_id', Auth::id())
            ->where('program_item_id', $program_item->id)
            ->first();

        $checked = false;
        $checked_at = null;

        if ($check) {
            $check->checked_at = $check->checked_at ? null : now();
            $check->save();
            $checked = $check->checked_at !== null;
            $checked_at = $check->checked_at?->format('Y年n月j日');
        } else {
            $check = ProgramCheck::create([
                'user_id' => Auth::id(),
                'program_item_id' => $program_item->id,
                'checked_at' => now(),
            ]);
            $checked = true;
            $checked_at = $check->checked_at->format('Y年n月j日');
        }

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
    }
}
