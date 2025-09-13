<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramCheck extends Model
{
    protected $fillable = [
        'user_id',
        'program_item_id',
        'checked_at',
        'note',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ProgramItem::class, 'program_item_id');
    }
}
