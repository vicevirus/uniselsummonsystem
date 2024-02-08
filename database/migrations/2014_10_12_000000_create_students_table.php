<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('matricNumber', 100)->primary();
            $table->string('password', 255)->nullable();
            $table->string('name', 100);
            $table->string('icNumber', 30)->nullable();
            $table->string('phoneNumber', 60)->nullable();
            $table->string('plateNumber', 35)->nullable();
            $table->string('address')->nullable();
            $table->string('carType', 100)->nullable();
            $table->string('QRCodeId', 100)->nullable()->unique();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
