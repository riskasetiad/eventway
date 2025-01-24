<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class site_config extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'logo', 'lokasi', 'email', 'telpon', 'instagram', 'x'];
    public $timestamps = true;
}
