<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'tiket_id', 'nama_lengkap', 'jenis_kelamin', 'tgl_lahir', 'email',
        'jumlah', 'total_harga', 'payment_type', 'status_pembayaran', 'status_tiket',
        'snap_token', 'payment_deadline',
    ];

    public $timestamps = true;

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
       public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
