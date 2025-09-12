<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();            // 例: week_1, week_2, month_2a, ... , year_1
            $table->string('name');
            $table->integer('offset_days')->default(0); // 入職日からの相対日数
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('milestones'); }
};
