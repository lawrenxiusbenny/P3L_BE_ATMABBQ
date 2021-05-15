<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bahans', function (Blueprint $table) {
            $table->bigIncrements('id_bahan');
            $table->bigInteger('id_menu');
            $table->string('nama_bahan');
            $table->integer('stok_bahan');
            $table->string('satuan_bahan');
            $table->string('tipe_bahan');
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
        Schema::dropIfExists('data_bahans');
    }
}
