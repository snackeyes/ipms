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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the payment method (e.g., Cash, Card)
            $table->enum('payment_option', ['None', 'Credit Card', 'Check', 'Loyalty']); // Payment options
            $table->decimal('surcharge_amount', 8, 2)->nullable(); // Surcharge amount (optional)
            $table->decimal('surcharge_percentage', 5, 2)->nullable(); // Surcharge percentage (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
