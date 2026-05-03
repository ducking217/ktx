<?php

namespace App\Mail;

use App\Models\Hopdong;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CanhBaoHetHanHopDong extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Hopdong $hopdong,
        public readonly int $mocCanhBaoNgay,
        public readonly string $loginUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cảnh báo sắp hết hạn hợp đồng lưu trú',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.canh-bao-het-han-hop-dong',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

