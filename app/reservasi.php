<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class reservasi extends Model
{
    protected $primaryKey = "id_reservasi";
    protected $fillable = [
        'id_customer','id_meja','id_karyawan','tanggal_reservasi', 'waktu_reservasi', 'jumlah_customer', 'kode_qr', 'status_reservasi','status_selesai','status_hapus'
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
}
