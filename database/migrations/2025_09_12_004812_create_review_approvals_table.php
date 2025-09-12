<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('review_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('approver_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->index();               // director / manager_* / chief / educator / partner_nurse
            $table->timestamp('approved_at')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['review_id','approver_user_id']); // 同一承認者は一度だけ
        });
    }
    public function down(): void { Schema::dropIfExists('review_approvals'); }
};
