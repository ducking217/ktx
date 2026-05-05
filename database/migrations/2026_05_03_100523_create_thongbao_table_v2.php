<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thongbao', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('loai_thong_bao')->default('general'); // general, emergency, maintenance, finance
            $table->enum('doi_tuong_nhan', ['all', 'guest', 'sinhvien', 'admin'])->default('all');
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['doi_tuong_nhan', 'created_at'], 'thongbao_target_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thongbao');
    }
};
