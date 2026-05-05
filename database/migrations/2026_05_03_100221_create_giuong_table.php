<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giuong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            $table->string('ma_giuong')->unique(); // VD: 101-T1-GA
            $table->string('trang_thai')->default('available'); // available, occupied, broken
            $table->timestamps();
            $table->softDeletes();
            $table->index(['phong_id', 'trang_thai'], 'giuong_phong_trang_thai_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giuong');
    }
};
