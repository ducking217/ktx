<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        Schema::create('hopdong', function (Blueprint $table) use ($driver) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            $table->foreignId('giuong_id')->constrained('giuong')->cascadeOnDelete();
            
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->unsignedBigInteger('gia_thuc_te'); // Giá thuê lúc ký hợp đồng
            $table->unsignedBigInteger('tien_coc')->default(0);
            
            $table->enum('trang_thai', ['active', 'expired', 'terminated'])->default('active');
            if ($driver !== 'sqlite') {
                $table->tinyInteger('cot_hieu_luc')->storedAs("CASE WHEN `trang_thai` = 'active' THEN 1 ELSE NULL END");
            } else {
                $table->tinyInteger('cot_hieu_luc')->nullable();
            }
            $table->text('ghi_chu')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['sinhvien_id', 'trang_thai'], 'hopdong_sv_status_index');
            $table->index(['giuong_id', 'trang_thai'], 'hopdong_giuong_status_index');
            $table->index('ngay_ket_thuc');
            $table->unique(['sinhvien_id', 'cot_hieu_luc'], 'hopdong_mot_active_moi_sinhvien_unique');
            $table->unique(['giuong_id', 'cot_hieu_luc'], 'hopdong_mot_active_moi_giuong_unique');
        });

        if ($driver !== 'sqlite') {
            DB::statement('ALTER TABLE `hopdong` ADD CONSTRAINT `hopdong_ngay_hop_le_chk` CHECK (`ngay_ket_thuc` >= `ngay_bat_dau`)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hopdong');
    }
};
