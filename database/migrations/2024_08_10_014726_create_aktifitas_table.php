<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktifitas', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->enum('jenis_aktifitas', ['Simpan', 'Tarik']);
            $table->integer('jumlah'); // Ubah sesuai kebutuhan jika diperlukan
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('datanasabah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktifitas');
    }
};
