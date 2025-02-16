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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->string('email')->unique();
            $table->string('password'); // Ganti UUID ke string
            $table->string('phone_number', 15)->nullable(); // Bisa kosong
            $table->string('firstname');
            $table->string('lastname')->nullable(); // Bisa kosong
            $table->string('profile')->nullable(); // Bisa kosong
            $table->text('description')->nullable();  // Bisa kosong
            $table->string('foreground')->nullable(); // Bisa kosong
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
