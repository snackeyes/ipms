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
        Schema::create('customers', function (Blueprint $table) {
           $table->id();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('gender');
            $table->date('dob'); // Changed to `date` type for better handling of date of birth
            $table->string('nationality');
            $table->string('identity_type');
            $table->string('id_no'); // Consider renaming this column for clarity (e.g., `identity_number`)
            $table->string('id_front')->nullable(); // For storing the file path of ID front
            $table->string('id_back')->nullable(); // For storing the file path of ID back
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
