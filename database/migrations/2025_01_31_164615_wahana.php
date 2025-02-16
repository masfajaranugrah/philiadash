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
        Schema::create('wahana', function (Blueprint $table) {
            $table->id('id_wahana'); // Primary key
            $table->string('title', 255);
            $table->text('description'); // Menggunakan text karena deskripsi bisa panjang
            $table->decimal('price', 10, 2)->default(0.00); // Default 0.00 agar tidak null
            $table->string('location', 100)->nullable();
            $table->json('images')->nullable(); // Bisa menyimpan banyak gambar dalam bentuk JSON
            $table->timestamps();
            $table->softDeletes(); // Untuk fitur penghapusan sementara
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wahana');
    }
};
