<?php
namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'image', 'proposal', 'title', 'kategori_id', 'tgl_mulai', 'tgl_selesai',
        'kota', 'lokasi', 'url_lokasi', 'deskripsi', 'waktu_mulai',
        'waktu_selesai', 'status', 'alasan', 'slug',
    ];

    public function penyelenggara()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'event_kategori', 'event_id', 'kategori_id');
    }
    // Auto-generate slug saat membuat event baru
    protected static function booted()
    {
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title, '-');
        });
    }
}
