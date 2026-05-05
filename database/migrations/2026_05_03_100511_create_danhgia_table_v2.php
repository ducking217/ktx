<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danhgia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 sao
            $table->text('binh_luan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['phong_id', 'created_at'], 'danhgia_phong_created_index');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `danhgia` ADD CONSTRAINT `danhgia_rating_hop_le_chk` CHECK (`rating` BETWEEN 1 AND 5)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('danhgia');
    }
};
