<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'milestone_id',
        'target_date',
        'self_review',
        'challenges',
        'goals',
        'memo',
        'status',
    ];

    protected $casts = [
        'target_date' => 'date',
    ];

    /**
     * このレビューを作成したユーザー
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このレビューのマイルストーン
     */
    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    /**
     * このレビューの承認履歴
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(ReviewApproval::class);
    }

    /**
     * レビューが承認可能な状態かどうか
     */
    public function isApprovable(): bool
    {
        return $this->status === 'submitted' || $this->status === 'in_review';
    }

    /**
     * レビューが編集可能な状態かどうか
     */
    public function isEditable(): bool
    {
        return $this->status === 'draft' || $this->status === 'rejected';
    }
}
