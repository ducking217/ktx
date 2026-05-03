<?php

namespace App\Mail;

use App\Models\YeuCauGiaHan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KetQuaGiaHanHopDongMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly YeuCauGiaHan $yeuCauGiaHan,
        public readonly string $loginUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kết quả yêu cầu gia hạn hợp đồng',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ket-qua-gia-han-hop-dong',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

