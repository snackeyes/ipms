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
           $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete(); // Customer is optional
        $table->date('check_in');
        $table->date('check_out');
        $table->string('status')->default('pending'); // Values: pending, confirmed, cancelled
        $table->text('remarks')->nullable();
        $table->text('purpose_of_visit')->nullable();
        $table->string('source_of_booking')->nullable();
        $table->string('arrival_from')->nullable();
        $table->foreignId('room_type_id')->constrained()->cascadeOnDelete(); // Links to room_types table
        $table->integer('adults')->default(1); // Number of adults
        $table->integer('children')->default(0); // Number of children
         $table->decimal('room_tariff', 10, 2)->nullable();
        $table->string('meal_plan')->nullable(); // Example: Breakfast, Full Board, etc.
        $table->decimal('advance_payment', 10, 2)->nullable();
        $table->string('agent_name')->nullable();
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
