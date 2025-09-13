<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'employee_id' => [
                'required',
                'string',
                'unique:users',
                'regex:/^[A-Z]\d{4}$/'
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'hire_date' => ['required', 'date'],
            'password' => $this->passwordRules(),
        ], [
            'employee_id.required' => '職員IDは必須です。',
            'employee_id.unique' => 'この職員IDは既に使用されています。',
            'employee_id.regex' => '職員IDは大文字アルファベット1文字と4桁の数字の形式で入力してください（例：N0001）。',
            'full_name.required' => '氏名は必須です。',
            'full_name.max' => '氏名は255文字以内で入力してください。',
            'hire_date.required' => '入職日は必須です。',
            'hire_date.date' => '入職日は有効な日付を入力してください。',
        ])->validate();

        return User::create([
            'employee_id' => $input['employee_id'],
            'name' => $input['employee_id'], // 職員IDを表示名として使用
            'full_name' => $input['full_name'],
            'email' => $input['employee_id'] . '@hospital.local', // 一意性を保つためのダミーメール
            'password' => Hash::make($input['password']),
            'role' => 'new_nurse', // デフォルトで新入看護職員
            'hire_date' => $input['hire_date'],
        ]);
    }
}
