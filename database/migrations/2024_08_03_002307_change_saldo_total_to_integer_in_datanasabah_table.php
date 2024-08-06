<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('datanasabah', function (Blueprint $table) {
            // Mengubah tipe data saldo_total menjadi integer
            $table->integer('saldo_total')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datanasabah', function (Blueprint $table) {
            // Kembalikan tipe data saldo_total ke decimal jika perlu
            $table->decimal('saldo_total', 15, 2)->change();
        });
    }
};
