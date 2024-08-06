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
    Schema::create('rekapanbulanan', function (Blueprint $table) {
        $table->id();
        $table->string('nis');
        $table->decimal('saldo_awal', 15, 2);
        $table->decimal('saldo_akhir', 15, 2);
        $table->date('bulan');
        $table->timestamps();

        $table->foreign('nis')->references('nis')->on('datanasabah')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('rekapanbulanan');
}

};
