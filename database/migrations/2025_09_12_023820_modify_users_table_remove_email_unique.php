<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTableRemoveEmailUnique extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // メールアドレスの一意性制約を削除
            $table->dropUnique('users_email_unique');

            // メールアドレスをNULL許可に変更
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 元の状態に戻す
            $table->string('email')->unique()->change();
        });
    }
}
