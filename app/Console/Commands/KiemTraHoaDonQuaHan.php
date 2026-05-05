<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            $ids = DB::transaction(function () {
                $overdueInvoices = Hoadon::where('trang_thai', InvoiceStatus::Unpaid->value)
                    ->where('ngay_het_han', '<', Carbon::today())
                    ->lockForUpdate()
                    ->get();

                if ($overdueInvoices->isEmpty()) {
                    $this->info('Không có hóa đơn nào quá hạn cần cập nhật.');
                    return [];
                }

                $count = $overdueInvoices->count();
                $ids = $overdueInvoices->pluck('id')->toArray();

                Hoadon::whereIn('id', $ids)->update(['trang_thai' => InvoiceStatus::Overdue->value]);

                Log::info("Đã tự động chuyển trạng thái {$count} hóa đơn sang Overdue.", ['ids' => $ids]);
                $this->info("Thành công: Đã cập nhật {$count} hóa đơn sang trạng thái Overdue.");

                return $ids;
            });

            if (!empty($ids)) {
                $loginUrl = route('login');
                $hoaDons  = Hoadon::with(['hopdong.sinhvien.user'])->whereIn('id', $ids)->get();

                foreach ($hoaDons as $hoaDon) {
                    $email = $hoaDon->hopdong?->sinhvien?->user?->email;
                    if (!$email) continue;
                    Mail::to($email)->queue(new \App\Mail\NhacNoHoaDon($hoaDon, $loginUrl));
                }
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy Command hoadon:kiem-tra-qua-han: ' . $e->getMessage());
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
