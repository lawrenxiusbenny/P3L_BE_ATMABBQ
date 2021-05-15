<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Carbon\Carbon;

class Meja extends Model
{
    protected $primaryKey = "id_meja";
    protected $fillable = [
        'status_meja','no_meja','status_hapus'
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
