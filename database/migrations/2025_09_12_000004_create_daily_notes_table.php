<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('note_date')->comment('記録日');
            $table->text('activities')->comment('実施内容');
            $table->text('issues')->nullable()->comment('課題・困りごと・疑問');
            $table->text('learnings')->nullable()->comment('学び・気づき');
            $table->text('goals')->nullable()->comment('明日の目標');
            $table->timestamps();
            $table->softDeletes();

            // 同じ日の重複記録を防ぐ
            $table->unique(['user_id', 'note_date']);
        });

        Schema::create('daily_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_note_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commenter_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment')->comment('コメント内容');
            $table->boolean('is_partner_of_the_day')->default(false)->comment('当日の担当者フラグ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_comments');
        Schema::dropIfExists('daily_notes');
    }
};
