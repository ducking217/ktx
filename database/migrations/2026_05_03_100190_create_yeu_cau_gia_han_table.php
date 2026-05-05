<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yeu_cau_gia_han', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hopdong_id');
            $table->unsignedBigInteger('sinhvien_id');
            $table->date('ngay_ket_thuc_moi');
            $table->text('ly_do')->nullable();
            $table->string('trang_thai')->default('pending');
            $table->text('ghi_chu_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('hopdong_id', 'gia_han_hopdong_id_foreign');
            $table->index('sinhvien_id', 'gia_han_sinhvien_id_foreign');
            $table->index('trang_thai', 'gia_han_trang_thai_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_gia_han');
    }
};
