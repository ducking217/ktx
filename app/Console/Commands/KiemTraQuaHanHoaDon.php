<?php

namespace App\Console\Commands;

use App\Models\Hoadon;
use App\Enums\InvoiceStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KiemTraQuaHanHoaDon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoadon:kiem-tra-qua-han';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và chuyển trạng thái các hóa đơn quá hạn (sau 30 ngày)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Bắt đầu kiểm tra hóa đơn quá hạn...');

        // Hóa đơn được coi là quá hạn nếu sau 30 ngày kể từ ngày xuất mà vẫn ở trạng thái Pending
        $overdueDate = now()->subDays(30)->toDateString();

        $hoadons = Hoadon::where('trangthaithanhtoan', InvoiceStatus::Pending->value)
            ->whereDate('created_at', '<=', $overdueDate)
            ->get();

        if ($hoadons->isEmpty()) {
            $this->info('Không có hóa đơn nào quá hạn.');
            return Command::SUCCESS;
        }

        foreach ($hoadons as $hoadon) {
            DB::transaction(function () use ($hoadon) {
                $hoadon->update([
                    'trangthaithanhtoan' => InvoiceStatus::Overdue->value,
                ]);

                Log::info("Hóa đơn #{$hoadon->id} của SV {$hoadon->sinhvien_id} đã chuyển sang trạng thái quá hạn.");
            });

            $this->info("Đã chuyển trạng thái quá hạn cho hóa đơn #{$hoadon->id}");
        }

        $this->info('Đã hoàn thành kiểm tra hóa đơn quá hạn.');

        return Command::SUCCESS;
    }
}
