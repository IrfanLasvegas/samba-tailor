<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga_jasa extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    
    
    public function jasas()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function pengerjaans()
    {
        return $this->hasMany(Pengerjaan::class);
    }
}
