<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stok_masuk extends Model
{
    protected $primaryKey = "id_stok_masuk";
    public $timestamps = false;
    protected $fillable = [
        'id_bahan','jumlah_stok_masuk','harga_stok_masuk','tanggal_masuk'
    ];
}
