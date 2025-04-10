<?php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $qr = base64_encode(QrCode::format('png')->size(200)->generate($this->order->id));

        return $this->subject('Tiket Anda Berhasil Dibeli')
            ->view('emails.tiket_berhasil')
            ->with([
                'order' => $this->order,
                'qr'    => $qr,
            ]);
    }
}
