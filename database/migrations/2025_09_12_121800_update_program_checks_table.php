<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_checks', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_item_id')->constrained()->onDelete('cascade');
            $table->date('checked_at')->nullable();
            $table->text('note')->nullable();

            // 同じユーザーが同じ項目を重複チェックしないように
            $table->unique(['user_id', 'program_item_id']);
        });
    }

    public function down(): void
    {
        Schema::table('program_checks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['program_item_id']);
            $table->dropColumn(['user_id', 'program_item_id', 'checked_at', 'note']);
        });
    }
};
