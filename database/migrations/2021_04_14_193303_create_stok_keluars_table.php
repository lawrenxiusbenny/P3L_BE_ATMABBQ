<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_keluars', function (Blueprint $table) {
            $table->bigIncrements('id_stok_keluar');
            $table->bigInteger('id_bahan');
            $table->integer('jumlah_stok_keluar');
            $table->date('tanggal_keluar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_keluars');
    }
}
