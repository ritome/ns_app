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
            ->get()
            ->groupBy('category');

        $categories = ProgramItem::query()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('program-checks.index', [
            'items' => $items,
            'categories' => $categories,
            'selectedCategory' => $request->category
        ]);
    }

    public function toggle(Request $request, ProgramItem $item)
    {
        $check = ProgramCheck::where('user_id', Auth::id())
            ->where('program_item_id', $item->id)
            ->first();

        if ($check) {
            $check->checked_at = $check->checked_at ? null : now();
            $check->save();
        } else {
            ProgramCheck::create([
                'user_id' => Auth::id(),
                'program_item_id' => $item->id,
                'checked_at' => now(),
            ]);
        }

        return back()->with('success', '更新しました');
    }
}
