<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ProgramItem extends Model
{
    protected $fillable = [
        'category',
        'name',
        'description',
        'sort_order',
    ];

    protected $appends = ['checked_at'];

    public function checks(): HasMany
    {
        return $this->hasMany(ProgramCheck::class);
    }

    public function scopeByCategory($query, $category = null)
    {
        return $category
            ? $query->where('category', $category)
            : $query;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('category')->orderBy('sort_order')->orderBy('id');
    }

    public function isChecked(): bool
    {
        return $this->checked_at !== null;
    }

    public function getCheckedAtAttribute()
    {
        if (!$this->relationLoaded('checks')) {
            return null;
        }

        $userCheck = $this->checks->where('user_id', Auth::id())->first();
        return $userCheck ? $userCheck->checked_at : null;
    }
}
