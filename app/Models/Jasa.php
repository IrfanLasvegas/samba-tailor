<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function harga_jasas()
    {
        return $this->hasMany(Harga_jasa::class);
    }
}
