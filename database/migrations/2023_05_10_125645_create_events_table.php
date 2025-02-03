<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('start'); // Menyimpan tanggal dan waktu
            $table->dateTime('end')->nullable(); // Menyimpan waktu selesai acara (opsional)
            $table->boolean('allDay')->default(true); // Menandakan apakah acara sepanjang hari
            $table->string('className')->default('bg-info-subtle');
            $table->string('location')->nullable(); // Menyimpan lokasi acara
            $table->text('description')->nullable(); // Menyimpan deskripsi acara
            $table->json('extendedProps')->nullable(); // Menyimpan extendedProps dalam format JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
