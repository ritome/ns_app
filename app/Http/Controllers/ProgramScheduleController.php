<?php

namespace App\Http\Controllers;

use App\Models\ProgramItem;
use Illuminate\Http\Request;

class ProgramScheduleController extends Controller
{
    public function index()
    {
        $programItems = ProgramItem::orderBy('target_period')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('target_period');

        return view('program-schedule.index', [
            'programItems' => $programItems
        ]);
    }
}