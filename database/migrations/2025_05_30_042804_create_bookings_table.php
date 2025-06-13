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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->date('booking_date'); // Date of the booking
            $table->decimal('amount', 10, 2); // Amount for the booking
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // Status of the booking
            $table->string('address')->nullable(); // Address for the booking
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
