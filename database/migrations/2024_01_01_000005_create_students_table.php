<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('mobile')->nullable();
            $table->date('date')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
