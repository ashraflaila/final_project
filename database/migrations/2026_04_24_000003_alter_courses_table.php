<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->decimal('price', 8, 2)->after('description');
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('category_id');
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->dropColumn(['price', 'status']);
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
};
