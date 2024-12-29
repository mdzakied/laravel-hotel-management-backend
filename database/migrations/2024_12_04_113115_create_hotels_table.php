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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name')->unique();
            $table->string('address');
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->enum('status', ['pending', 'denied', 'approved'])->default('pending');
            $table->text('status_reason')->nullable()->default('no reason');
            $table->json('superadmin')->nullable();
            $table->json('owner')->nullable();
            $table->json('admin')->nullable();
            $table->json('staff')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
