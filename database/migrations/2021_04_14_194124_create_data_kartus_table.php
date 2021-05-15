<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKartusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kartus', function (Blueprint $table) {
            $table->bigIncrements('id_data_kartu');
            $table->string('nomor_kartu');
            $table->string('kode_verifikasi');
            $table->string('nama_pemilik_kartu');
            $table->string('jenis_kartu');
            $table->date('expired_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kartus');
    }
}
