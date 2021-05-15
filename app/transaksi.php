<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $primaryKey = "id_transaksi";
    public $timestamps = false;
    protected $fillable = [
        'id_data_kartu','id_karyawan','id_reservasi','total_harga','tanggal_pembayaran','waktu_pembayaran','metode_pembayaran'
    ];
}
