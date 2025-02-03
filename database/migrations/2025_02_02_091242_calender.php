<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('calenders', function (Blueprint $table) {
            $table->bigIncrements('id');  

            $table->string('title');
            $table->dateTime('start'); // Store start date and time
            $table->dateTime('end'); // Store end date and time
            $table->boolean('allDay'); // Store whether the event is all day
            $table->string('className') ;
            $table->string('location') ;
            $table->string('description') ;
         
            $table->timestamps();
        });
    }
 
  
    public function down()
    {
        Schema::dropIfExists('calenders');
    }
};
