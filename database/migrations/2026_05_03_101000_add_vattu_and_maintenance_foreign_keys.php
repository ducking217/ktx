<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vattu', function (Blueprint $table) {
            $table->foreign('phong_id', 'vattu_phong_id_foreign')
                ->references('id')
                ->on('phong')
                ->cascadeOnDelete();
        });

        Schema::table('lich_su_bao_tri', function (Blueprint $table) {
            $table->foreign('phong_id', 'lich_su_bao_tri_phong_id_foreign')
                ->references('id')
                ->on('phong')
                ->cascadeOnDelete();
            $table->foreign('vattu_id', 'lich_su_bao_tri_vattu_id_foreign')
                ->references('id')
                ->on('vattu')
                ->nullOnDelete();
        });

        Schema::table('yeu_cau_gia_han', function (Blueprint $table) {
            $table->foreign('hopdong_id', 'yeu_cau_gia_han_hopdong_id_foreign')
                ->references('id')
                ->on('hopdong')
                ->cascadeOnDelete();
            $table->foreign('sinhvien_id', 'yeu_cau_gia_han_sinhvien_id_foreign')
                ->references('id')
                ->on('sinhvien')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lich_su_bao_tri', function (Blueprint $table) {
            $table->dropForeign('lich_su_bao_tri_phong_id_foreign');
            $table->dropForeign('lich_su_bao_tri_vattu_id_foreign');
        });

        Schema::table('yeu_cau_gia_han', function (Blueprint $table) {
            $table->dropForeign('yeu_cau_gia_han_hopdong_id_foreign');
            $table->dropForeign('yeu_cau_gia_han_sinhvien_id_foreign');
        });

        Schema::table('vattu', function (Blueprint $table) {
            $table->dropForeign('vattu_phong_id_foreign');
        });
    }
};
