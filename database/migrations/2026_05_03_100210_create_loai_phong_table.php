<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loai_phong', function (Blueprint $table) {
            $table->id();
            $table->string('ten_loai')->unique(); // VD: Standard 8, VIP 4
            $table->unsignedInteger('suc_chua');
            $table->unsignedBigInteger('gia_thang');
            $table->json('tien_nghi')->nullable(); // Lưu: ['dieu_hoa', 'wifi', 'nong_lanh']
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loai_phong');
    }
};
