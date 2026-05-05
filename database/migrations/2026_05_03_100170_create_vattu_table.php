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
        Schema::create('vattu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phong_id');
            $table->string('ten_vat_tu');
            $table->integer('so_luong')->default(1);
            $table->string('tinh_trang')->nullable();
            $table->text('mo_ta')->nullable();
            $table->date('ngay_mua')->nullable();
            $table->string('thoi_gian_bao_hanh')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vattu');
    }
};
