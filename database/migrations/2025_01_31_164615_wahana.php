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
            $table->bigIncrements('id_wahana'); // Primary key
            $table->string('title', 255);
            $table->text('description'); // Menggunakan text karena deskripsi bisa panjang
            $table->decimal('price', 10, 2)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('images', 255)->nullable();
            $table->timestamps();
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
