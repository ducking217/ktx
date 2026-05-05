<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kyluat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('muc_do')->default('low'); // low, medium, high
            $table->date('ngay_vi_pham');
            $table->string('hinh_thuc_xu_ly')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyluat');
    }
};
