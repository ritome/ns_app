<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('milestone_id')->constrained()->cascadeOnDelete();
            $table->date('target_date');      // 対象期間の終了日
            $table->text('self_review');      // 自己評価
            $table->text('challenges')->nullable(); // 課題・困ったこと
            $table->text('goals')->nullable(); // 次期の目標
            $table->text('memo')->nullable();  // その他メモ
            $table->enum('status', ['draft', 'submitted', 'in_review', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
            $table->softDeletes();

            // 同一ユーザーの同一マイルストーンの重複を防ぐ
            $table->unique(['user_id', 'milestone_id']);
        });

        // 承認履歴テーブル
        Schema::create('review_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
            $table->string('role');           // 承認者の役職
            $table->text('comment')->nullable(); // 承認時のコメント
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // 同一レビューに対する同一承認者の重複を防ぐ
            $table->unique(['review_id', 'approver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_approvals');
        Schema::dropIfExists('reviews');
    }
};
