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
        Schema::create('check_outs', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('check_in_id'); // Link to the check-in
    $table->decimal('additional_charges', 10, 2)->default(0);
    $table->decimal('discount', 10, 2)->default(0);
    $table->decimal('rest_payment', 10, 2); // Remaining balance to be paid
    $table->string('payment_status')->default('Pending'); // Pending, Paid
    $table->timestamps();

    $table->foreign('check_in_id')->references('id')->on('check_ins')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_outs');
    }
};
