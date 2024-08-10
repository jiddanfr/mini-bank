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
    public function up(): void
    {
        Schema::create('pengaturan_administrasi', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom 'id' sebagai primary key
            $table->integer('biaya_penarikan')->unsigned()->default(0);
            $table->integer('biaya_penyimpanan')->unsigned()->default(0);
            $table->integer('administrasi_bulanan')->unsigned()->default(0);
            $table->integer('minimal_saldo_tarik')->unsigned()->default(0);
            $table->integer('minimal_jumlah_saldo')->unsigned()->default(0);
            $table->integer('minimal_simpanan')->unsigned()->default(0); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_administrasi');
    }
};
