<?php
namespace App\Mail;

use App\Models\Pesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PesanTerkirim extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Pesan $pesan)
    {
        $this->pesan = $pesan;
    }

    public function build()
    {
        return $this->view('admin.emails.pesanTerkirim') // Pastikan nama view sesuai
            ->with([
                'nama'    => $this->pesan->nama,
                'email'   => $this->pesan->email,
                'telepon' => $this->pesan->telepon,
                'subjek'  => $this->pesan->subjek,
                'pesan'   => $this->pesan->pesan,
            ]);
    }
}
