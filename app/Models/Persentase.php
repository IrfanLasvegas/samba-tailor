<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persentase extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function bagians()
    {
        return $this->belongsTo(Bagian::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pengerjaans()
    {
        return $this->hasMany(Pengerjaan::class);
    }
}
