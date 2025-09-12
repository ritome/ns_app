<?php

namespace Database\Seeders;

use App\Models\Milestone;
use Illuminate\Database\Seeder;

class MilestonesSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            [
                'key' => 'week_1',
                'name' => '1週間目',
                'days_after' => 7,
                'description' => '入職後1週間の振り返り',
            ],
            [
                'key' => 'week_2',
                'name' => '2週間目',
                'days_after' => 14,
                'description' => '入職後2週間の振り返り',
            ],
            [
                'key' => 'week_3',
                'name' => '3週間目',
                'days_after' => 21,
                'description' => '入職後3週間の振り返り',
            ],
            [
                'key' => 'week_4',
                'name' => '4週間目',
                'days_after' => 28,
                'description' => '入職後1ヶ月の振り返り',
            ],
            [
                'key' => 'month_2_first',
                'name' => '2ヶ月目（前半）',
                'days_after' => 45,
                'description' => '入職後2ヶ月目前半の振り返り',
            ],
            [
                'key' => 'month_2_second',
                'name' => '2ヶ月目（後半）',
                'days_after' => 60,
                'description' => '入職後2ヶ月目後半の振り返り',
            ],
            [
                'key' => 'month_3',
                'name' => '3ヶ月目',
                'days_after' => 90,
                'description' => '入職後3ヶ月の振り返り',
            ],
            [
                'key' => 'month_6',
                'name' => '6ヶ月目',
                'days_after' => 180,
                'description' => '入職後6ヶ月の振り返り',
            ],
            [
                'key' => 'month_9',
                'name' => '9ヶ月目',
                'days_after' => 270,
                'description' => '入職後9ヶ月の振り返り',
            ],
            [
                'key' => 'year_1',
                'name' => '1年目',
                'days_after' => 365,
                'description' => '入職後1年の振り返り',
            ],
        ];

        foreach ($milestones as $milestone) {
            Milestone::create($milestone);
        }
    }
}
