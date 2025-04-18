<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kategori'];
    public $timestamps  = true;

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_kategori');
    }

}
