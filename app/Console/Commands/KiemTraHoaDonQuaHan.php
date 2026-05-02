<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KiemTraHoaDonQuaHan extends Command
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
    protected $description = 'Kiểm tra và tự động cập nhật trạng thái hóa đơn đã quá hạn thanh toán (> 30 ngày)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Đang kiểm tra hóa đơn quá hạn (trên 30 ngày)...');

        try {
            DB::transaction(function () {
                $overdueInvoices = Hoadon::where('trangthaithanhtoan', InvoiceStatus::Pending->value)
                    ->where('ngayxuat', '<=', Carbon::today()->subDays(30))
                    ->lockForUpdate()
                    ->get();

                if ($overdueInvoices->isEmpty()) {
                    $this->info('Không có hóa đơn nào quá hạn cần cập nhật.');
                    return;
                }

                $count = $overdueInvoices->count();
                $ids = $overdueInvoices->pluck('id')->toArray();

                Hoadon::whereIn('id', $ids)->update([
                    'trangthaithanhtoan' => InvoiceStatus::Overdue->value,
                ]);

                Log::info("Đã tự động chuyển trạng thái {$count} hóa đơn sang Overdue.", ['ids' => $ids]);
                $this->info("Thành công: Đã cập nhật {$count} hóa đơn sang trạng thái Overdue.");
                
                // TODO: Gửi Notification / Email nhắc nhở sinh viên thanh toán
            });

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy Command hoadon:kiem-tra-qua-han: ' . $e->getMessage());
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
