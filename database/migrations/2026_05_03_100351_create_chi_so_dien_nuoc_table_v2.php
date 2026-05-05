<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_so_dien_nuoc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            
            $table->enum('loai', ['dien', 'nuoc']);
            $table->unsignedInteger('chi_so_cu');
            $table->unsignedInteger('chi_so_moi');
            $table->unsignedTinyInteger('thang');
            $table->unsignedSmallInteger('nam');
            
            $table->timestamps();
            
            $table->unique(['phong_id', 'loai', 'thang', 'nam']); // Đảm bảo 1 phòng chỉ có 1 chỉ số/loại/tháng
            $table->index(['thang', 'nam'], 'chi_so_ky_index');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `chi_so_dien_nuoc` ADD CONSTRAINT `chi_so_hop_le_chk` CHECK (`chi_so_moi` >= `chi_so_cu` AND `thang` BETWEEN 1 AND 12)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_so_dien_nuoc');
    }
};
