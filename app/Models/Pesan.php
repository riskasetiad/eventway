<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'telepon', 'subjek', 'pesan'];
    public $timestamps  = true;
}
