<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class data_bahan extends Model
{
    protected $primaryKey = "id_bahan";
    protected $fillable = [
        'id_menu','nama_bahan','stok_bahan','satuan_bahan','tipe_bahan'
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
