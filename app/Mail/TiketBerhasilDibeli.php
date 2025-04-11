<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TiketBerhasilDibeli extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Tiket Anda Berhasil Dibeli')
            ->view('admin.emails.tiket_berhasil')
            ->with([
                'order' => $this->order,
            ]);
    }
}
