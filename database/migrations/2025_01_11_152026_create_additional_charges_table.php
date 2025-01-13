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
        Schema::create('check_in_additional_charges', function (Blueprint $table) {
            $table->id();
        $table->foreignId('check_in_id')->constrained('check_ins')->onDelete('cascade');
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
        Schema::dropIfExists('check_in_additional_charges');
    }
};
