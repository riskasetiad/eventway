<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class home_slider extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'image'];
    public $timestamps = true;
}
