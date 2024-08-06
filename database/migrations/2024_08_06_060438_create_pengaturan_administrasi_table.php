<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanAdministrasiTable extends Migration
{
    public function up()
    {
        Schema::create('pengaturan_administrasi', function (Blueprint $table) {
            $table->integer('biaya_penarikan')->unsigned()->default(0);
            $table->integer('biaya_penyimpanan')->unsigned()->default(0);
            $table->integer('administrasi_bulanan')->unsigned()->default(0);
            $table->integer('minimal_saldo_tarik')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan_administrasi');
    }
}

