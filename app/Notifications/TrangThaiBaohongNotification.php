<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\BaohongStatus;
use App\Models\Baohong;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification gửi khi Admin cập nhật trạng thái báo hỏng.
 * Kênh: database (Notification Center) + email.
 */
final class TrangThaiBaohongNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Baohong $baohong,
        private readonly string  $trangThaiMoi,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        $statusValue = $this->baohong->trang_thai instanceof BaohongStatus ? $this->baohong->trang_thai->value : null;
        $icon = match ($statusValue) {
            BaohongStatus::Processing->value => 'wrench',
            BaohongStatus::Done->value => 'check-circle',
            BaohongStatus::Rejected->value => 'x-circle',
            default => 'tool',
        };

        $body = "Yêu cầu báo hỏng tại phòng {$this->baohong->phong?->ten_phong} đã chuyển sang: **{$this->trangThaiMoi}**.";

        return [
            'type'       => 'baohong_capnhat',
            'icon'       => $icon,
            'title'      => "Cập nhật sửa chữa: {$this->trangThaiMoi}",
            'body'       => $body,
            'action_url' => route('student.danhsachbaohong'),
            'baohong_id' => $this->baohong->id,
            'trang_thai' => $this->trangThaiMoi,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("Cập nhật báo hỏng – {$this->trangThaiMoi}")
            ->greeting('Xin chào ' . ($notifiable->name ?? 'Sinh viên') . ',')
            ->line("Yêu cầu báo hỏng của bạn đã được cập nhật: **{$this->trangThaiMoi}**.");

        return $mail->action('Xem chi tiết', route('student.danhsachbaohong'));
    }
}
