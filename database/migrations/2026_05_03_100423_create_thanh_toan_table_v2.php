<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoadon_id')->constrained('hoadon')->cascadeOnDelete();
            $table->foreignId('nguoi_xac_nhan')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('phuong_thuc', ['cash', 'transfer', 'online', 'other'])->default('cash');
            $table->string('ma_giao_dich')->nullable();
            $table->unsignedBigInteger('so_tien');
            $table->timestamp('ngay_giao_dich');
            $table->text('ghi_chu')->nullable();
            
            $table->timestamps();
            $table->index(['hoadon_id', 'ngay_giao_dich'], 'thanh_toan_hoadon_time_index');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `thanh_toan` ADD CONSTRAINT `thanh_toan_so_tien_duong_chk` CHECK (`so_tien` > 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
    }
};
