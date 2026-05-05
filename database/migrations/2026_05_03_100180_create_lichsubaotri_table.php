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
        Schema::create('lich_su_bao_tri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phong_id');
            $table->unsignedBigInteger('vattu_id')->nullable();
            $table->date('ngay_bao_tri');
            $table->text('noi_dung')->nullable();
            $table->decimal('chi_phi', 15, 2)->default(0);
            $table->string('don_vi_thuc_hien')->nullable();
            $table->string('nguoi_thuc_hien')->nullable();
            $table->enum('trang_thai', ['planned', 'done', 'cancelled'])->default('planned');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_bao_tri');
    }
};
