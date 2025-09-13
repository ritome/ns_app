<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Milestone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'days_after',
        'description',
    ];

    /**
     * このマイルストーンに関連する振り返り
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class)->where('user_id', Auth::id());
    }

    /**
     * 現在のユーザーの振り返りが存在するかどうか
     */
    public function hasReview(): bool
    {
        return $this->review()->exists();
    }

    /**
     * 期限が過ぎているかどうか
     */
    public function isOverdue(): bool
    {
        $deadline = Auth::user()->hire_date->addDays($this->days_after);
        return now()->greaterThan($deadline);
    }

    /**
     * 期限までの残り日数
     */
    public function daysUntilDeadline(): int
    {
        $deadline = Auth::user()->hire_date->addDays($this->days_after);
        return max(0, now()->diffInDays($deadline, false));
    }

    /**
     * 期限が近いかどうか（7日以内）
     */
    public function isDeadlineApproaching(): bool
    {
        return !$this->isOverdue() && $this->daysUntilDeadline() <= 7;
    }
}
