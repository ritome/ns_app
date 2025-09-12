<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'full_name' => ['required', 'string', 'max:255'],
            'hire_date' => ['required', 'date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'employee_id' => '職員ID',
            'full_name' => '氏名',
            'hire_date' => '入職日',
        ];
    }
}
