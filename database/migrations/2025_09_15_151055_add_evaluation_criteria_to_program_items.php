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
        Schema::table('program_items', function (Blueprint $table) {
            $table->json('level_1_criteria')->nullable()->comment('レベル1の評価基準');
            $table->json('level_2_criteria')->nullable()->comment('レベル2の評価基準');
            $table->json('level_3_criteria')->nullable()->comment('レベル3の評価基準');
            $table->text('evaluation_points')->nullable()->comment('評価のポイント');
            $table->text('reference_materials')->nullable()->comment('参考資料');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_items', function (Blueprint $table) {
            $table->dropColumn([
                'level_1_criteria',
                'level_2_criteria',
                'level_3_criteria',
                'evaluation_points',
                'reference_materials'
            ]);
        });
    }
};
