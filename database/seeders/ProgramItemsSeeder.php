<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramItemsSeeder extends Seeder
{
    public function run(): void
    {
        // 代表カテゴリ＋項目（まずは20件）
        $items = [
            // 栄養ケア
            ['category'=>'栄養ケア','name'=>'食事介助','description'=>null,'sort_order'=>10],
            ['category'=>'栄養ケア','name'=>'口腔ケア','description'=>null,'sort_order'=>20],
            ['category'=>'栄養ケア','name'=>'経管栄養','description'=>null,'sort_order'=>30],
            ['category'=>'栄養ケア','name'=>'胃瘻の取り扱い','description'=>null,'sort_order'=>40],

            // 清潔ケア
            ['category'=>'清潔ケア','name'=>'入浴介助','description'=>null,'sort_order'=>10],
            ['category'=>'清潔ケア','name'=>'全身清拭','description'=>null,'sort_order'=>20],
            ['category'=>'清潔ケア','name'=>'陰部洗浄','description'=>null,'sort_order'=>30],
            ['category'=>'清潔ケア','name'=>'更衣','description'=>null,'sort_order'=>40],

            // 排泄ケア
            ['category'=>'排泄ケア','name'=>'オムツ交換・尿器／トイレ介助','description'=>null,'sort_order'=>10],
            ['category'=>'排泄ケア','name'=>'浣腸','description'=>null,'sort_order'=>20],
            ['category'=>'排泄ケア','name'=>'摘便','description'=>null,'sort_order'=>30],
            ['category'=>'排泄ケア','name'=>'ストーマケア','description'=>null,'sort_order'=>40],

            // ADL介助
            ['category'=>'ADL介助','name'=>'体位交換','description'=>null,'sort_order'=>10],
            ['category'=>'ADL介助','name'=>'バギーへの移乗','description'=>null,'sort_order'=>20],
            ['category'=>'ADL介助','name'=>'姿勢保持装置','description'=>null,'sort_order'=>30],

            // フィジカルアセスメント
            ['category'=>'フィジカルアセスメント','name'=>'バイタルサイン','description'=>null,'sort_order'=>10],
            ['category'=>'フィジカルアセスメント','name'=>'呼吸音聴診','description'=>null,'sort_order'=>20],
            ['category'=>'フィジカルアセスメント','name'=>'腸蠕動音聴診','description'=>null,'sort_order'=>30],

            // 検査・処置（代表）
            ['category'=>'検査','name'=>'採血','description'=>null,'sort_order'=>10],
            ['category'=>'処置','name'=>'気管吸引','description'=>null,'sort_order'=>10],
        ];

        foreach ($items as $it) {
            DB::table('program_items')->updateOrInsert(
                ['category'=>$it['category'], 'name'=>$it['name']],
                $it + ['created_at'=>now(),'updated_at'=>now()]
            );
        }
    }
}
