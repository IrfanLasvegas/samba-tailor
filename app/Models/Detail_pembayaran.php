<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pembayaran extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function pembayarans()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function pengerjaans()
    {
        return $this->belongsTo(Pengerjaan::class);
    }
}
