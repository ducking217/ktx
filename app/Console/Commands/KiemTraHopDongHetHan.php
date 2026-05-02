<?php

namespace App\Console\Commands;

use App\Enums\ContractStatus;
use App\Models\Hopdong;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                
                // TODO: Gửi Notification / Email nhắc nhở sinh viên và admin
            });

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy Command hopdong:kiem-tra-het-han: ' . $e->getMessage());
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
