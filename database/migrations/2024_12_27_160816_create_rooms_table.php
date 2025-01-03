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
        Schema::create('rooms', function (Blueprint $table) {
             $table->id();
            $table->string('room_number')->unique(); // Room Number
            $table->unsignedBigInteger('floor_id');  // Foreign Key to Floor
            $table->unsignedBigInteger('room_type_id'); // Foreign Key to Room Type
            $table->float('base_price');             // Base Price
            $table->timestamps();

            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
