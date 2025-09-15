<?php

namespace Database\Seeders;

use App\Models\ProgramItem;
use Illuminate\Database\Seeder;

class ProgramItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // 1週目〜2週目（西棟）
            ['category' => '西棟日勤業務', 'name' => '食事介助', 'description' => '基本的な食事介助の実施', 'sort_order' => 10],
            ['category' => '西棟日勤業務', 'name' => '水分補給', 'description' => '適切な水分補給の実施', 'sort_order' => 20],
            ['category' => '西棟日勤業務', 'name' => '経管栄養', 'description' => '経管栄養の管理と手順', 'sort_order' => 30],
            ['category' => '西棟日勤業務', 'name' => '胃瘻・腸瘻', 'description' => '胃瘻・腸瘻の管理', 'sort_order' => 40],
            ['category' => '西棟日勤業務', 'name' => '排泄ケア', 'description' => '適切な排泄ケアの実施', 'sort_order' => 50],
            ['category' => '西棟日勤業務', 'name' => 'バギー操作', 'description' => '安全なバギー操作', 'sort_order' => 60],
            ['category' => '西棟日勤業務', 'name' => '移乗', 'description' => '安全な移乗介助', 'sort_order' => 70],
            ['category' => '西棟日勤業務', 'name' => '処置', 'description' => '基本的な処置の実施', 'sort_order' => 80],
            ['category' => '西棟日勤業務', 'name' => '与薬', 'description' => '確実な与薬業務', 'sort_order' => 90],
            ['category' => '西棟日勤業務', 'name' => '吸入', 'description' => '適切な吸入の実施', 'sort_order' => 100],

            // 2ヶ月目（東棟）
            ['category' => '東棟日勤業務', 'name' => 'スマートベスト', 'description' => 'スマートベストの適切な使用', 'sort_order' => 110],
            ['category' => '東棟日勤業務', 'name' => '採血・培養', 'description' => '採血・培養の実施手順', 'sort_order' => 120],
            ['category' => '東棟日勤業務', 'name' => '入浴介助', 'description' => '安全な入浴介助', 'sort_order' => 130],
            ['category' => '東棟日勤業務', 'name' => '洗体', 'description' => '適切な洗体の実施', 'sort_order' => 140],
            ['category' => '東棟日勤業務', 'name' => '処置', 'description' => '各種処置の実施', 'sort_order' => 150],

            // 2〜3ヶ月頃
            ['category' => '西棟・早日勤業務', 'name' => '通院介助', 'description' => '安全な通院介助の実施', 'sort_order' => 160],
            ['category' => '西棟・早日勤業務', 'name' => '耳鼻科診', 'description' => '耳鼻科診察の補助', 'sort_order' => 170],
            ['category' => '西棟・早日勤業務', 'name' => '整形外科診', 'description' => '整形外科診察の補助', 'sort_order' => 180],
            ['category' => '西棟・早日勤業務', 'name' => '休日日勤会', 'description' => '休日日勤会の参加', 'sort_order' => 190],
            ['category' => '西棟・早日勤業務', 'name' => '定期薬作成', 'description' => '定期薬の適切な作成', 'sort_order' => 200],

            // 西棟遅番業務
            ['category' => '西棟遅番業務', 'name' => '遅番業務全般', 'description' => '遅番業務の理解と実施', 'sort_order' => 210],

            // リーダー業務
            ['category' => 'リーダー業務', 'name' => '西棟リーダー業務', 'description' => '西棟でのリーダー業務', 'sort_order' => 220],
            ['category' => 'リーダー業務', 'name' => '東棟リーダー業務', 'description' => '東棟でのリーダー業務', 'sort_order' => 230],

            // 夜勤業務
            ['category' => '夜勤業務', 'name' => '西棟夜勤業務', 'description' => '西棟での夜勤業務', 'sort_order' => 240],
            ['category' => '夜勤業務', 'name' => '東棟夜勤業務', 'description' => '東棟での夜勤業務', 'sort_order' => 250],

            // 変則勤務
            ['category' => '変則勤務', 'name' => '個別支援計画', 'description' => '個別支援計画の作成と評価', 'sort_order' => 260],
            ['category' => '変則勤務', 'name' => 'モニタリングカンファレンス', 'description' => 'モニタリングカンファレンスへの参加', 'sort_order' => 270],

            // 習得支援
            ['category' => '習得支援', 'name' => '西棟日勤業務流れ', 'description' => '西棟日勤業務の基本的な流れの理解', 'sort_order' => 280],
            ['category' => '習得支援', 'name' => '西棟日勤業務流れ(入浴)', 'description' => '入浴を含む西棟日勤業務の流れの理解', 'sort_order' => 290],
            ['category' => '習得支援', 'name' => 'たんぽ業務', 'description' => 'たんぽ業務の理解と実施', 'sort_order' => 300],
            ['category' => '習得支援', 'name' => '内服マニュアル', 'description' => '内服管理マニュアルの理解', 'sort_order' => 310],
            ['category' => '習得支援', 'name' => '看護手順', 'description' => '基本的な看護手順の理解', 'sort_order' => 320],
            ['category' => '習得支援', 'name' => '医療安全マニュアル', 'description' => '医療安全マニュアルの理解', 'sort_order' => 330],
            ['category' => '習得支援', 'name' => '感染対策マニュアル', 'description' => '感染対策マニュアルの理解', 'sort_order' => 340],
            ['category' => '習得支援', 'name' => '夜勤業務(西棟)', 'description' => '西棟夜勤業務の理解', 'sort_order' => 350],
            ['category' => '習得支援', 'name' => '夜勤業務(たんぽ)', 'description' => 'たんぽ夜勤業務の理解', 'sort_order' => 360],
            ['category' => '習得支援', 'name' => '看護マニュアル', 'description' => '看護マニュアル全般の理解', 'sort_order' => 370],
        ];

        foreach ($items as $item) {
            ProgramItem::create($item);
        }
    }
}
