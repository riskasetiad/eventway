<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id','image','title','kategori_id','tgl_mulai','tgl_selesai','kota','lokasi','url_lokasi','deskripsi',
    'waktu_mulai','waktu_selesai','status','slug'];
    public $timestamps = true;
}

