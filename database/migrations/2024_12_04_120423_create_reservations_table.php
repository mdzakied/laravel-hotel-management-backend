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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');  // Gunakan foreignId
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');    // Gunakan foreignId
            $table->string('customer_name');
            $table->string('customer_email');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->integer('guest_count');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status_payment', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
