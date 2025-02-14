<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'title', 'harga', 'stok', 'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
