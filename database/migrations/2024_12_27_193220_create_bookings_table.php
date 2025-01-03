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
    
    // Foreign Keys
    $table->foreignId('reservation_id')->constrained()->onDelete('cascade');  // Reference to the reservation
    $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');  // Reference to the customer (if not selected, nullable)
    $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');  // Reference to the room (allocated room)
    $table->string('agent_id')->nullable()->onDelete('set null');  // Reference to the agent (if applicable)
    $table->string('meal_plan_id')->nullable()->onDelete('set null');  // Reference to meal plan (if applicable)
    
    // Booking details
    $table->string('room_type')->nullable();  // Type of room
    $table->integer('pax')->nullable();  // Number of people (adults/children)
    $table->decimal('room_tariff', 10, 2)->nullable();  // Room rate
    $table->decimal('advance_payment', 10, 2)->nullable();  // Amount of advance payment
    
    // Dates
    $table->date('check_in_date');
    $table->date('check_out_date');
    
    // Status
    $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'canceled'])->default('pending');
    
    // Payment Summary
    $table->decimal('total_amount', 10, 2)->nullable();  // Total booking amount
    $table->decimal('remaining_balance', 10, 2)->nullable();  // Remaining balance to be paid
    
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
