<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapanTable extends Migration
{
    public function up()
    {
        Schema::create('rekapan', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->string('nis'); // Kolom NIS
            $table->string('bulan'); // Kolom bulan
            $table->string('tahun', 4); // Kolom tahun
            $table->integer('total_simpanan'); // Kolom total_simpanan
            $table->integer('total_penarikan'); // Kolom total_penarikan
            $table->integer('saldo_awal'); // Kolom saldo_awal
            $table->integer('saldo_akhir'); // Kolom saldo_akhir
            $table->timestamps(); // Kolom created_at dan updated_at

            $table->foreign('nis')->references('nis')->on('datanasabah')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekapan');
    }
}
