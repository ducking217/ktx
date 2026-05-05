<?php

namespace App\Console\Commands;

use App\Enums\ContractStatus;
use App\Models\Hopdong;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KiemTraHopDongHetHan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hopdong:kiem-tra-het-han';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và tự động cập nhật trạng thái hợp đồng đã hết hạn (Expired)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Đang kiểm tra hợp đồng hết hạn...');

        try {
            $loginUrl = route('login');

            $sap30Ngay = Hopdong::where('trang_thai', ContractStatus::Active->value)
                ->whereBetween('ngay_ket_thuc', [now()->addDays(28), now()->addDays(30)])
                ->with('sinhvien.user')
                ->get();

            foreach ($sap30Ngay as $hopdong) {
                $email = $hopdong->sinhvien?->user?->email;
                if (! $email) continue;
                Mail::to($email)->queue(new \App\Mail\CanhBaoHetHanHopDong($hopdong, 30, $loginUrl));
            }

            $sap7Ngay = Hopdong::where('trang_thai', ContractStatus::Active->value)
                ->whereBetween('ngay_ket_thuc', [now()->addDays(5), now()->addDays(7)])
                ->with('sinhvien.user')
                ->get();

            foreach ($sap7Ngay as $hopdong) {
                $email = $hopdong->sinhvien?->user?->email;
                if (! $email) continue;
                Mail::to($email)->queue(new \App\Mail\CanhBaoHetHanHopDong($hopdong, 7, $loginUrl));
            }

            DB::transaction(function () {
                $expiredContracts = Hopdong::where('trang_thai', ContractStatus::Active->value)
                    ->where('ngay_ket_thuc', '<', Carbon::today())
                    ->lockForUpdate()
                    ->get();

                if ($expiredContracts->isEmpty()) {
                    $this->info('Không có hợp đồng nào hết hạn cần cập nhật.');
                    return;
                }

                $count = $expiredContracts->count();
                $ids = $expiredContracts->pluck('id')->toArray();

                Hopdong::whereIn('id', $ids)->update([
                    'trang_thai' => ContractStatus::Expired->value,
                ]);

                Log::info("Đã tự động chuyển trạng thái {$count} hợp đồng sang Expired.", ['ids' => $ids]);
                $this->info("Thành công: Đã cập nhật {$count} hợp đồng sang trạng thái Expired.");
            });

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy Command hopdong:kiem-tra-het-han: ' . $e->getMessage());
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
