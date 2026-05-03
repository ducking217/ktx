<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yeu_cau_gia_han', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hopdong_id')->constrained('hopdong')->cascadeOnDelete();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            $table->date('ngay_ket_thuc_moi');
            $table->text('ly_do')->nullable();
            $table->enum('trang_thai', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('ghi_chu_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['sinhvien_id', 'trang_thai']);
            $table->index(['hopdong_id', 'trang_thai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_gia_han');
    }
};

