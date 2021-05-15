<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->bigIncrements('id_pesanan');
            $table->bigInteger('id_menu');
            $table->bigInteger('id_transaksi');
            $table->bigInteger('id_reservasi');
            $table->date('tanggal_pemesanan');
            $table->integer('jumlah');
            $table->double('subtotal');
            $table->string('status_penyajian')->default('Unserved');
            $table->integer('status_bayar')->default(0);
            $table->integer('status_selesai')->default(0);
            $table->integer('status_checkout')->default(0);
            $table->integer('status_hapus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}

