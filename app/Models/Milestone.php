<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Milestone extends Model
{
    protected $fillable = [
        'key',
        'name',
        'days_after',
        'description',
    ];

    /**
     * このマイルストーンに関連するレビュー
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
