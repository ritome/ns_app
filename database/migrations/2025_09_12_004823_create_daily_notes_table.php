<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('daily_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();  // 新入看護職員
            $table->date('date');
            $table->text('content')->nullable();  // 実施内容
            $table->text('issue')->nullable();    // 困りごと/疑問/課題
            $table->timestamps();

            $table->unique(['user_id','date']);   // 1ユーザー1日1件
        });
    }
    public function down(): void { Schema::dropIfExists('daily_notes'); }
};
