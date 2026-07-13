<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pemesanan $pemesanan;

    public function __construct(Pemesanan $pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pemesanan #' . $this->pemesanan->id . ' — Tinggal-Klik',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
            with: [
                'pemesanan' => $this->pemesanan,
            ],
        );
    }
}
