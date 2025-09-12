<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramItem extends Model
{
    protected $fillable = [
        'category',
        'name',
        'description',
        'sort_order',
    ];

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
}
