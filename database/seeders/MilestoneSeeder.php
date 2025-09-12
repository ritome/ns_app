<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MilestoneSeeder extends Seeder
{
    public function run(): void
    {
        // 入職日からの相対日数（ざっくり運用開始目安）
        $rows = [
            ['key'=>'week_1',   'name'=>'1週間の振り返り',  'offset_days'=> 7,   'sort_order'=> 10],
            ['key'=>'week_2',   'name'=>'2週間の振り返り',  'offset_days'=>14,   'sort_order'=> 20],
            ['key'=>'week_3',   'name'=>'3週間の振り返り',  'offset_days'=>21,   'sort_order'=> 30],
            ['key'=>'week_4',   'name'=>'4週間の振り返り',  'offset_days'=>28,   'sort_order'=> 40],
            ['key'=>'month_2a', 'name'=>'2か月目 前半',      'offset_days'=>45,   'sort_order'=> 50],
            ['key'=>'month_2b', 'name'=>'2か月目 後半',      'offset_days'=>60,   'sort_order'=> 60],
            ['key'=>'month_3',  'name'=>'3か月の振り返り',   'offset_days'=>90,   'sort_order'=> 70],
            ['key'=>'month_4',  'name'=>'4か月の振り返り',   'offset_days'=>120,  'sort_order'=> 80],
            ['key'=>'month_5',  'name'=>'5か月の振り返り',   'offset_days'=>150,  'sort_order'=> 90],
            ['key'=>'month_6',  'name'=>'6か月の振り返り',   'offset_days'=>180,  'sort_order'=>100],
            ['key'=>'month_7',  'name'=>'7か月の振り返り',   'offset_days'=>210,  'sort_order'=>110],
            ['key'=>'month_8',  'name'=>'8か月の振り返り',   'offset_days'=>240,  'sort_order'=>120],
            ['key'=>'month_9',  'name'=>'9か月の振り返り',   'offset_days'=>270,  'sort_order'=>130],
            ['key'=>'month_10', 'name'=>'10か月の振り返り',  'offset_days'=>300,  'sort_order'=>140],
            ['key'=>'month_11', 'name'=>'11か月の振り返り',  'offset_days'=>330,  'sort_order'=>150],
            ['key'=>'year_1',   'name'=>'1年の振り返り',     'offset_days'=>365,  'sort_order'=>160],
        ];

        foreach ($rows as $r) {
            DB::table('milestones')->updateOrInsert(
                ['key' => $r['key']],
                $r + ['created_at'=>now(),'updated_at'=>now()]
            );
        }
    }
}
