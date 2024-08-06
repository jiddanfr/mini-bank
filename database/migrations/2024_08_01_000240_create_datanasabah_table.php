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
    Schema::create('datanasabah', function (Blueprint $table) {
        $table->string('nis')->primary(); // NIS sebagai primary key
        $table->string('nama');
        $table->string('kelas');
        $table->decimal('saldo_total', 15, 2)->default(0); // Saldo total
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('datanasabah');
}

};
