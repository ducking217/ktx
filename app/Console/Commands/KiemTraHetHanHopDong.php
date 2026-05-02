<?php

namespace App\Console\Commands;

use App\Models\Hopdong;
use App\Enums\ContractStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KiemTraHetHanHopDong extends Command
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
    protected $description = 'Kiểm tra và chuyển trạng thái các hợp đồng đã hết hạn';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Bắt đầu kiểm tra hợp đồng hết hạn...');

        $now = now()->toDateString();

        $hopdongs = Hopdong::where('trang_thai', ContractStatus::Active->value)
            ->whereDate('ngay_ket_thuc', '<', $now)
            ->get();

        if ($hopdongs->isEmpty()) {
            $this->info('Không có hợp đồng nào hết hạn.');
            return Command::SUCCESS;
        }

        foreach ($hopdongs as $hopdong) {
            DB::transaction(function () use ($hopdong) {
                $hopdong->update([
                    'trang_thai' => ContractStatus::Expired->value,
                ]);

                // Ghi log hoặc gửi thông báo tại đây nếu cần
                Log::info("Hợp đồng #{$hopdong->id} của SV {$hopdong->sinhvien_id} đã hết hạn.");
            });

            $this->info("Đã chuyển trạng thái hết hạn cho hợp đồng #{$hopdong->id}");
        }

        $this->info('Đã hoàn thành kiểm tra hợp đồng hết hạn.');

        return Command::SUCCESS;
    }
}
