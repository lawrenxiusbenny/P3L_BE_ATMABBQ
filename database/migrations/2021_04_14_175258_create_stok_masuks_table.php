<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_masuks', function (Blueprint $table) {
            $table->bigIncrements('id_stok_masuk');
            $table->bigInteger('id_bahan');
            $table->integer('jumlah_stok_masuk');
            $table->double('harga_stok_masuk');
            $table->date('tanggal_masuk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_masuks');
    }
}
