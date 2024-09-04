<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatrekapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayatrekapan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');
            $table->integer('tahun');
            $table->decimal('total_simpanan', 15, 2);
            $table->decimal('total_penarikan', 15, 2);
            $table->decimal('saldo_awal', 15, 2);
            $table->decimal('saldo_akhir', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayatrekapan');
    }
}
