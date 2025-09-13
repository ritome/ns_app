<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DailyNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'note_date',
        'activities',
        'issues',
        'learnings',
        'goals',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    /**
     * 記録者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメント
     */
    public function comments()
    {
        return $this->hasMany(DailyComment::class);
    }

    /**
     * 担当者のコメント
     */
    public function partnerComment()
    {
        return $this->comments()
            ->where('is_partner_of_the_day', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * 編集可能か（3日以内）
     */
    public function isEditable()
    {
        return $this->note_date->diffInDays(now()) <= 3;
    }
}