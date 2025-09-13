<?php

namespace Database\Seeders;

use App\Models\ProgramItem;
use Illuminate\Database\Seeder;

class ProgramItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // 栄養ケア
            ['category' => '栄養ケア', 'name' => '食事介助', 'description' => '基本的な食事介助の技術を習得', 'sort_order' => 1],
            ['category' => '栄養ケア', 'name' => '経管栄養', 'description' => '経管栄養の管理と手順の理解', 'sort_order' => 2],
            ['category' => '栄養ケア', 'name' => '嚥下障害のケア', 'description' => '嚥下障害のアセスメントとケア', 'sort_order' => 3],

            // 清潔ケア
            ['category' => '清潔ケア', 'name' => '入浴介助', 'description' => '安全な入浴介助の実施', 'sort_order' => 1],
            ['category' => '清潔ケア', 'name' => '清拭', 'description' => '全身清拭の手順と注意点', 'sort_order' => 2],
            ['category' => '清潔ケア', 'name' => '口腔ケア', 'description' => '口腔ケアの実施と評価', 'sort_order' => 3],

            // 排泄ケア
            ['category' => '排泄ケア', 'name' => 'おむつ交換', 'description' => '適切なおむつ交換の手順', 'sort_order' => 1],
            ['category' => '排泄ケア', 'name' => '導尿管理', 'description' => '導尿の管理と感染予防', 'sort_order' => 2],
            ['category' => '排泄ケア', 'name' => 'ストーマケア', 'description' => 'ストーマの管理と指導', 'sort_order' => 3],

            // フィジカルアセスメント
            ['category' => 'フィジカルアセスメント', 'name' => 'バイタルサイン測定', 'description' => '正確なバイタルサイン測定', 'sort_order' => 1],
            ['category' => 'フィジカルアセスメント', 'name' => '呼吸音の聴取', 'description' => '呼吸音の聴取と評価', 'sort_order' => 2],
            ['category' => 'フィジカルアセスメント', 'name' => '腸蠕動音の聴取', 'description' => '腸蠕動音の聴取と評価', 'sort_order' => 3],

            // 与薬
            ['category' => '与薬', 'name' => '内服薬の管理', 'description' => '内服薬の準備と確認', 'sort_order' => 1],
            ['category' => '与薬', 'name' => '注射の準備', 'description' => '無菌操作による注射の準備', 'sort_order' => 2],
            ['category' => '与薬', 'name' => '点滴管理', 'description' => '点滴の管理と観察', 'sort_order' => 3],

            // 安全管理
            ['category' => '安全管理', 'name' => '転倒予防', 'description' => '転倒リスクの評価と予防', 'sort_order' => 1],
            ['category' => '安全管理', 'name' => '感染予防', 'description' => '標準予防策の実施', 'sort_order' => 2],
            ['category' => '安全管理', 'name' => '医療機器の取扱い', 'description' => '医療機器の安全な操作', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            ProgramItem::create($item);
        }
    }
}
