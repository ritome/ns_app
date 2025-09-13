<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['employee_id' => 'N0001', 'full_name' => '新入 看護', 'role' => 'new_nurse'],
            ['employee_id' => 'N0002', 'full_name' => '新人 二郎', 'role' => 'new_nurse'],

            ['employee_id' => 'P0001', 'full_name' => '相方 花子', 'role' => 'partner_nurse'],
            ['employee_id' => 'E0001', 'full_name' => '教育 太郎', 'role' => 'educator'],
            ['employee_id' => 'C0001', 'full_name' => '主任 一郎', 'role' => 'chief'],

            ['employee_id' => 'M1001', 'full_name' => '課長 安全', 'role' => 'manager_safety'],
            ['employee_id' => 'M1002', 'full_name' => '課長 感染', 'role' => 'manager_infection'],
            ['employee_id' => 'M1003', 'full_name' => '課長 人材', 'role' => 'manager_hrd'],

            ['employee_id' => 'D0001', 'full_name' => '部長 太郎', 'role' => 'director'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['employee_id' => $u['employee_id']],
                $u + [
                    'password'   => Hash::make('password'), // DEV: 全員 "password"
                    'hire_date'  => now()->subDays(random_int(0, 60))->toDateString(),
                ]
            );
        }
    }
}
