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
            ['employee_id'=>'N0001','full_name'=>'新入 看護','name'=>'新入 看護','email'=>'new1@example.com','role'=>'new_nurse'],
            ['employee_id'=>'N0002','full_name'=>'新人 二郎','name'=>'新人 二郎','email'=>'new2@example.com','role'=>'new_nurse'],

            ['employee_id'=>'P0001','full_name'=>'相方 花子','name'=>'相方 花子','email'=>'partner@example.com','role'=>'partner_nurse'],
            ['employee_id'=>'E0001','full_name'=>'教育 太郎','name'=>'教育 太郎','email'=>'educator@example.com','role'=>'educator'],
            ['employee_id'=>'C0001','full_name'=>'主任 一郎','name'=>'主任 一郎','email'=>'chief@example.com','role'=>'chief'],

            ['employee_id'=>'M1001','full_name'=>'課長 安全','name'=>'課長 安全','email'=>'mgr_safety@example.com','role'=>'manager_safety'],
            ['employee_id'=>'M1002','full_name'=>'課長 感染','name'=>'課長 感染','email'=>'mgr_infection@example.com','role'=>'manager_infection'],
            ['employee_id'=>'M1003','full_name'=>'課長 人材','name'=>'課長 人材','email'=>'mgr_hrd@example.com','role'=>'manager_hrd'],

            ['employee_id'=>'D0001','full_name'=>'部長 太郎','name'=>'部長 太郎','email'=>'director@example.com','role'=>'director'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                $u + [
                    'password'   => Hash::make('password'), // DEV: 全員 "password"
                    'hire_date'  => now()->subDays(random_int(0,60))->toDateString(),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
