<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('aktifitas', function (Blueprint $table) {
            $table->integer('jumlah')->change();
        });
    }

    public function down()
    {
        Schema::table('aktifitas', function (Blueprint $table) {
            $table->decimal('jumlah', 15, 2)->change();
        });
    }
};
