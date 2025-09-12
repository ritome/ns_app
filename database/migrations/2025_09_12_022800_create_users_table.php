<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->string('employee_id')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->after('name');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->after('email_verified_at');
            }
            if (!Schema::hasColumn('users', 'hire_date')) {
                $table->date('hire_date')->nullable()->after('role');
            }
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'full_name', 'role', 'hire_date']);
            $table->dropSoftDeletes();
        });
    }
}
