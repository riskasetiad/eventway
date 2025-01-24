<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiket extends Model
{
    use HasFactory;
    protected $fillable = ['id','event_id','title','harga','stok','status'];
    public $timestamps = true;
}

