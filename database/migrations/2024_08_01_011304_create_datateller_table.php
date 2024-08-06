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
        Schema::create('datateller', function (Blueprint $table) {
            $table->id(); // ID auto increment
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('datateller');
    }
    
};
