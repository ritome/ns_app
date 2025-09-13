<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'daily_note_id',
        'commenter_id',
        'comment',
        'is_partner_of_the_day',
    ];

    protected $casts = [
        'is_partner_of_the_day' => 'boolean',
    ];

    /**
     * 日々の振り返り
     */
    public function dailyNote()
    {
        return $this->belongsTo(DailyNote::class);
    }

    /**
     * コメント投稿者
     */
    public function commenter()
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}