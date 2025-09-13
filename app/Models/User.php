<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'full_name',
        'password',
        'role',
        'hire_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'hire_date' => 'date',
    ];

    public function username()
    {
        return 'employee_id';
    }

    // nameアクセサ - full_nameの値を返す
    public function getNameAttribute()
    {
        return $this->full_name;
    }

    // nameミューテタ - full_nameに値を設定
    public function setNameAttribute($value)
    {
        $this->attributes['full_name'] = $value;
    }
}
