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
        Schema::create('room_types', function (Blueprint $table) {
             $table->id();
            $table->string('name')->unique(); // Room Type Name
            $table->integer('base_adult');    // Base number of adults
            $table->integer('base_child');    // Base number of children
            $table->integer('max_adult');     // Max number of adults
            $table->integer('max_child');     // Max number of children
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
