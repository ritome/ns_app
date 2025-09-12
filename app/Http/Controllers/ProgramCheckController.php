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
        $items = ProgramItem::with(['checks' => function ($query) {
            $query->where('user_id', Auth::id());
        }])
            ->byCategory($request->category)
            ->ordered()
            ->get()
            ->groupBy('category');

        $categories = ProgramItem::distinct()->pluck('category');

        return view('program-checks.index', compact('items', 'categories'));
    }

    public function toggle(Request $request, ProgramItem $item)
    {
        $check = ProgramCheck::firstOrNew([
            'user_id' => Auth::id(),
            'program_item_id' => $item->id,
        ]);

        if ($check->exists && $check->checked_at) {
            $check->checked_at = null;
        } else {
            $check->checked_at = now();
        }

        $check->note = $request->note;
        $check->save();

        return back()->with('success', '更新しました。');
    }
}
