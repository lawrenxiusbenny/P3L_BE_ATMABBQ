<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->bigInteger('id_data_kartu');
            $table->bigInteger('id_karyawan');
            $table->bigInteger('id_reservasi');
            $table->double('total_harga');
            $table->date('tanggal_pembayaran');
            $table->time('waktu_pembayaran');
            $table->string('metode_pembayaran');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
