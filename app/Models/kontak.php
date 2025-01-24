<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kontak extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama', 'email', 'deskripsi'];
    public $timestamps = true;
}
