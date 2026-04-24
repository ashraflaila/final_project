<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->after('last_name');
            }

            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });

        Schema::table('admins', function (Blueprint $table) {
            if (! Schema::hasColumn('admins', 'remember_token')) {
                $table->rememberToken()->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn('remember_token');
            }

            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }

            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }
        });

        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
