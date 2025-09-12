<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('program_items', function (Blueprint $table) {
            $table->id();
            $table->string('category')->index();        // 例: 栄養ケア/清潔ケア/排泄ケア/ADL/フィジカル...
            $table->string('name');                     // 項目名（例：食事介助、経管栄養 など）
            $table->text('description')->nullable();    // 補足説明
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category','name']);        // 同カテゴリ内で一意
        });
    }
    public function down(): void { Schema::dropIfExists('program_items'); }
};
