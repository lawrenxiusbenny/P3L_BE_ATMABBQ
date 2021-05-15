<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stok_keluar extends Model
{
    protected $primaryKey = "id_stok_keluar";
    public $timestamps = false;
    protected $fillable = [
        'id_bahan','jumlah_stok_keluar','tanggal_keluar'
    ];
}
