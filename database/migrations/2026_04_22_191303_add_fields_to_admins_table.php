<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name')->nullable()->after('email');
            $table->string('last_name')->nullable()->after('name');
            $table->unsignedBigInteger('country_id')->nullable()->after('last_name');
            $table->string('mobile')->nullable()->after('country_id');
            $table->date('date')->nullable()->after('mobile');
            $table->string('address')->nullable()->after('date');
            $table->enum('gender', ['Male', 'Female'])->default('Male')->after('address');
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('gender');
            $table->string('image')->nullable()->after('status');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn([
                'name', 'last_name', 'country_id', 'mobile',
                'date', 'address', 'gender', 'status', 'image',
                'created_at', 'updated_at',
            ]);
        });
    }
};
