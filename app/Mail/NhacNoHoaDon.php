<?php

namespace App\Mail;

use App\Models\Hoadon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NhacNoHoaDon extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Hoadon $hoadon,
        public readonly string $loginUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nhắc nhở thanh toán hóa đơn ký túc xá',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nhac-no-hoa-don',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

