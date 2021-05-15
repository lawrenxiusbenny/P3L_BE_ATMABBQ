<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    protected $primaryKey = "id_customer";
    protected $fillable = [
        'nama_customer','email_customer','telepon_customer','status_hapus'
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
