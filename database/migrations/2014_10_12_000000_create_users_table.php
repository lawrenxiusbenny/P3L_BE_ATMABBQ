<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id_karyawan');
            $table->bigInteger('id_role');
            $table->string('nama_karyawan');
            $table->string('jenis_kelamin');
            $table->string('telepon_karyawan');
            $table->string('email_karyawan')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('tanggal_bergabung');
            $table->string('password');
            $table->string('status')->default('aktif');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
