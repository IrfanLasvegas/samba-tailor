<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengerjaan extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function persentases()
    {
        return $this->belongsTo(Persentase::class);
    }

    public function harga_jasas()
    {
        return $this->belongsTo(Harga_jasa::class);
    }

    public function detail_pembayarans()
    {
        return $this->hasOne(Detail_pembayaran::class);
    }
    
}
