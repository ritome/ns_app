<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();      // 新入看護職員
            $table->foreignId('milestone_id')->constrained()->cascadeOnDelete(); // 節目
            $table->string('status')->default('draft');   // draft/submitted/approved_partially/approved_all
            $table->json('content')->nullable();          // 設問の回答をJSONで保持
            $table->timestamps();

            $table->unique(['user_id','milestone_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('reviews'); }
};
