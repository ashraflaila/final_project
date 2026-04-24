<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('content');
            $table->integer('duration')->nullable()->after('video_url'); // assuming minutes
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('course_id');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'duration']);
        });
    }
};
