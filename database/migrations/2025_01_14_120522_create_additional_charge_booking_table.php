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
        Schema::create('additional_charge_booking', function (Blueprint $table) {
            $table->id();
        $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
        $table->foreignId('additional_charge_id')->constrained('additional_charges')->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_charge_booking');
    }
};
