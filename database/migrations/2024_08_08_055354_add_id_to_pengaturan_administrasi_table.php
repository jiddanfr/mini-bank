<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToPengaturanAdministrasiTable extends Migration
{
    public function up()
    {
        Schema::table('pengaturan_administrasi', function (Blueprint $table) {
            // Menambahkan kolom 'id' sebagai primary key
            $table->id()->first(); // Menambahkan kolom 'id' sebagai autoincrement primary key
        });
    }

    public function down()
    {
        Schema::table('pengaturan_administrasi', function (Blueprint $table) {
            // Menghapus kolom 'id' jika rollback
            $table->dropColumn('id');
        });
    }
}
