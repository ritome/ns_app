<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('daily_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_note_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commenter_id')->constrained('users')->cascadeOnDelete(); // コメントした看護師
            $table->boolean('is_partner_of_the_day')->default(false); // 当日の担当者か
            $table->text('comment');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('daily_comments'); }
};
