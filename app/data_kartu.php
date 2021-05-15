<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_kartu extends Model
{
    protected $primaryKey = "id_data_kartu";
    public $timestamps = false;
    protected $fillable = [
        'nomor_kartu', 'kode_verifikasi', 'nama_pemilik_kartu', 'jenis_kartu', 'expired_date'
    ];
}
