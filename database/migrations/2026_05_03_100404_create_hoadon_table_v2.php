<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hoadon', function (Blueprint $table) {
            $table->id();
            
            // Liên kết (Cái nào có thì điền)
            $table->foreignId('hopdong_id')->nullable()->constrained('hopdong')->nullOnDelete();
            $table->foreignId('phong_id')->nullable()->constrained('phong')->nullOnDelete();
            
            $table->string('ma_hoa_don')->unique();
            $table->enum('loai_hoadon', ['monthly', 'deposit', 'refund', 'extra'])->default('monthly');
            $table->unsignedBigInteger('tien_phong')->default(0);
            $table->unsignedBigInteger('tien_dien')->default(0);
            $table->unsignedBigInteger('tien_nuoc')->default(0);
            $table->unsignedBigInteger('phi_dich_vu')->default(0);
            $table->unsignedBigInteger('tong_tien')->default(0);
            $table->enum('trang_thai', ['unpaid', 'paid', 'overdue', 'cancelled'])->default('unpaid');
            
            $table->date('ngay_het_han')->nullable();
            $table->date('ngay_thanh_toan')->nullable();
            
            $table->text('ghi_chu')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['trang_thai', 'ngay_het_han'], 'hoadon_status_due_index');
            $table->index(['hopdong_id', 'trang_thai'], 'hoadon_hopdong_status_index');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `hoadon` ADD CONSTRAINT `hoadon_tong_tien_hop_le_chk` CHECK (`tong_tien` = (`tien_phong` + `tien_dien` + `tien_nuoc` + `phi_dich_vu`))');
            DB::statement("ALTER TABLE `hoadon` ADD CONSTRAINT `hoadon_ngay_thanh_toan_chk` CHECK ((`trang_thai` <> 'paid') OR (`ngay_thanh_toan` IS NOT NULL))");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hoadon');
    }
};
