<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->bigIncrements('id_reservasi');
            $table->bigInteger('id_customer');
            $table->bigInteger('id_meja');
            $table->bigInteger('id_karyawan');
            $table->date('tanggal_reservasi');
            $table->string('waktu_reservasi');
            $table->integer('jumlah_customer');
            $table->string('kode_qr');
            $table->string('status_reservasi')->default('Belum Datang');
            $table->string('status_hapus')->default('0');
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
        Schema::dropIfExists('reservasis');
    }
}
