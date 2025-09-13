<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewApproval extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'approver_id',
        'role',
        'comment',
        'approved_at',
        'rejected_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * 対象のレビュー
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * 承認者
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * 承認済みかどうか
     */
    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    /**
     * 差戻しかどうか
     */
    public function isRejected(): bool
    {
        return $this->rejected_at !== null;
    }

    /**
     * 承認者の役職名を取得
     */
    public function getRoleName(): string
    {
        return match ($this->role) {
            'partner_nurse' => 'パートナー看護師',
            'educator' => '教育係',
            'chief' => '主任',
            'manager_safety' => '課長（医療安全）',
            'manager_infection' => '課長（感染制御）',
            'manager_hrd' => '課長（人材育成）',
            'director' => '部長',
            default => '不明',
        };
    }
}
