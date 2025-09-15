<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_items', function (Blueprint $table) {
            $table->json('evaluation_targets')->nullable()->comment('到達目標（評価指標）');
            $table->string('target_period')->nullable()->comment('目標期間（1週目、2週目など）');
            $table->string('location')->nullable()->comment('実施場所（西棟、東棟など）');
        });
    }

    public function down(): void
    {
        Schema::table('program_items', function (Blueprint $table) {
            $table->dropColumn(['evaluation_targets', 'target_period', 'location']);
        });
    }
};
