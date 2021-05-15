<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $primaryKey = "id_pesanan";
    public $timestamps = false;
    protected $fillable = [
        'id_menu','id_transaksi','id_reservasi','tanggal_pemesanan','jumlah','sub_total','id_stok_keluar','status_penyajian','status_bayar','status_selesai','status_checkout','status_hapus'
    ];
}
