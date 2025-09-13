<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    use HasFactory;

    /**
     * ステータス定数
     */
    public const STATUS_DRAFT = 'draft';           // 下書き
    public const STATUS_SUBMITTED = 'submitted';    // 提出済み（承認待ち）
    public const STATUS_APPROVED = 'approved';      // 承認済み
    public const STATUS_REJECTED = 'rejected';      // 差戻し

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'self_review',
        'challenges',
        'goals',
        'memo',
        'status',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'target_date' => 'date',
    ];

    /**
     * 作成者
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 対象の節目
     */
    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    /**
     * 承認履歴
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(ReviewApproval::class);
    }

    /**
     * 提出済みかどうか
     */
    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    /**
     * 承認済みかどうか
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * 差戻しされているかどうか
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * 編集可能かどうか
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
        ]);
    }

    /**
     * 承認可能かどうか
     */
    public function isApprovable(): bool
    {
        // 自分のレビューは承認できない
        if (Auth::id() === $this->user_id) {
            return false;
        }

        // 承認済みの場合は承認できない
        if ($this->isApproved()) {
            return false;
        }

        // 提出前のレビューは承認できない
        if (!$this->isSubmitted()) {
            return false;
        }

        // 役職に応じた承認権限をチェック
        return match (Auth::user()->role) {
            'partner_nurse' => !$this->isApprovedByRole('partner_nurse'),
            'educator' => !$this->isApprovedByRole('educator'),
            'chief' => !$this->isApprovedByRole('chief'),
            'manager_safety' => !$this->isApprovedByRole('manager_safety'),
            'manager_infection' => !$this->isApprovedByRole('manager_infection'),
            'manager_hrd' => !$this->isApprovedByRole('manager_hrd'),
            'director' => !$this->isApprovedByRole('director'),
            default => false,
        };
    }

    /**
     * 指定された役職の承認者による承認が完了しているかどうか
     */
    public function isApprovedByRole(string $role): bool
    {
        return $this->approvals()
            ->where('role', $role)
            ->whereNotNull('approved_at')
            ->exists();
    }

    /**
     * 全ての承認者による承認が完了しているかどうか
     */
    public function isFullyApproved(): bool
    {
        // 必要な承認者の役職一覧
        $requiredRoles = [
            'partner_nurse',    // パートナー看護師
            'educator',         // 教育係
            'chief',           // 主任
            'manager_safety',   // 課長（医療安全）
            'manager_infection', // 課長（感染制御）
            'manager_hrd',      // 課長（人材育成）
            'director',         // 部長
        ];

        // 全ての役職で承認が完了しているかチェック
        foreach ($requiredRoles as $role) {
            if (!$this->isApprovedByRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 承認を実行
     */
    public function approve(string $comment = null): void
    {
        // 承認履歴を作成
        $this->approvals()->create([
            'approver_id' => Auth::id(),
            'role' => Auth::user()->role,
            'comment' => $comment,
            'approved_at' => now(),
        ]);

        // 全ての承認が完了した場合はステータスを更新
        if ($this->isFullyApproved()) {
            $this->update(['status' => self::STATUS_APPROVED]);
        }
    }

    /**
     * 差戻しを実行
     */
    public function reject(string $comment): void
    {
        // 承認履歴を作成（差戻し）
        $this->approvals()->create([
            'approver_id' => Auth::id(),
            'role' => Auth::user()->role,
            'comment' => $comment,
            'rejected_at' => now(),
        ]);

        // ステータスを差戻しに更新
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    /**
     * 提出を実行
     */
    public function submit(): void
    {
        $this->update([
            'status' => self::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);
    }

    /**
     * 承認進捗率を計算
     */
    public function getApprovalProgressPercentage(): int
    {
        $requiredRoles = [
            'partner_nurse',
            'educator',
            'chief',
            'manager_safety',
            'manager_infection',
            'manager_hrd',
            'director',
        ];

        $approvedCount = 0;
        foreach ($requiredRoles as $role) {
            if ($this->isApprovedByRole($role)) {
                $approvedCount++;
            }
        }

        return round(($approvedCount / count($requiredRoles)) * 100);
    }

    /**
     * 承認状態のラベルを取得
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => '下書き',
            self::STATUS_SUBMITTED => '承認待ち',
            self::STATUS_APPROVED => '承認済み',
            self::STATUS_REJECTED => '差戻し',
            default => '不明',
        };
    }

    /**
     * 承認状態のカラーを取得（Tailwind CSS用）
     */
    public function getStatusColor(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_SUBMITTED => 'yellow',
            self::STATUS_APPROVED => 'emerald',
            self::STATUS_REJECTED => 'rose',
            default => 'gray',
        };
    }
}
