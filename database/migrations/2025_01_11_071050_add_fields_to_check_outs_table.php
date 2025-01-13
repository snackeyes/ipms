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
        Schema::table('check_outs', function (Blueprint $table) {
            $table->json('additional_charges')->nullable(); // To store multiple charges
        $table->decimal('discount', 8, 2)->nullable();  // Discount in amount
        $table->string('discount_remarks')->nullable(); // Remarks for discount
        $table->decimal('gst', 8, 2)->nullable();       // GST amount
        $table->decimal('final_amount', 10, 2); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_outs', function (Blueprint $table) {
            //
        });
    }
};
