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
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:new_nurse,partner_nurse,educator,chief,manager_safety,manager_infection,manager_hrd,director'],
            'password' => $this->passwordRules(),
        ], [
            'employee_id.required' => '職員IDは必須です。',
            'employee_id.unique' => 'この職員IDは既に使用されています。',
            'employee_id.regex' => '職員IDは大文字アルファベット1文字と4桁の数字の形式で入力してください（例：N0001）。',
            'name.required' => '名前（表示名）は必須です。',
            'name.max' => '名前（表示名）は255文字以内で入力してください。',
            'full_name.required' => '氏名は必須です。',
            'full_name.max' => '氏名は255文字以内で入力してください。',
            'role.required' => '役割は必須です。',
            'role.in' => '選択された役割は無効です。',
        ])->validate();

        return User::create([
            'employee_id' => $input['employee_id'],
            'name' => $input['name'],
            'full_name' => $input['full_name'],
            'email' => $input['employee_id'] . '@hospital.local', // 一意性を保つためのダミーメール
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
            'hire_date' => now()->toDateString(),
        ]);
    }
}
