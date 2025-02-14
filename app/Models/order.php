<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['id','tiket_id','nama_lengkap','jenis_kelamin','tgl_lahir','email','jumlah','total_harga',
    'payment_type','status_pembayaran','status_tiket','snap_token'];
    public $timestamps = true;
}
