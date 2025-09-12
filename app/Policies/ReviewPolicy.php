<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * レビューの閲覧権限をチェック
     */
    public function view(User $user, Review $review): bool
    {
        // 自分のレビューは閲覧可能
        if ($user->id === $review->user_id) {
            return true;
        }

        // 承認者（パートナー看護師、教育係、主任、課長、部長）は閲覧可能
        return in_array($user->role, [
            'partner_nurse',    // パートナー看護師
            'educator',         // 教育係
            'chief',           // 主任
            'manager_safety',   // 課長（医療安全）
            'manager_infection', // 課長（感染制御）
            'manager_hrd',      // 課長（人材育成）
            'director',         // 部長
        ]);
    }

    /**
     * レビューの編集権限をチェック
     */
    public function update(User $user, Review $review): bool
    {
        // 自分のレビューのみ編集可能
        return $user->id === $review->user_id;
    }

    /**
     * レビューの提出権限をチェック
     */
    public function submit(User $user, Review $review): bool
    {
        // 自分のレビューのみ提出可能
        return $user->id === $review->user_id;
    }

    /**
     * レビューの承認権限をチェック
     */
    public function approve(User $user, Review $review): bool
    {
        // 自分のレビューは承認できない
        if ($user->id === $review->user_id) {
            return false;
        }

        // 承認済みのレビューは承認できない
        if ($review->isApproved()) {
            return false;
        }

        // 提出前のレビューは承認できない
        if (!$review->isSubmitted()) {
            return false;
        }

        // 役職に応じた承認権限をチェック
        return match ($user->role) {
            'partner_nurse' => !$review->isApprovedByRole('partner_nurse'),
            'educator' => !$review->isApprovedByRole('educator'),
            'chief' => !$review->isApprovedByRole('chief'),
            'manager_safety' => !$review->isApprovedByRole('manager_safety'),
            'manager_infection' => !$review->isApprovedByRole('manager_infection'),
            'manager_hrd' => !$review->isApprovedByRole('manager_hrd'),
            'director' => !$review->isApprovedByRole('director'),
            default => false,
        };
    }
}
