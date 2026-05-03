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
        // Add to phong
        Schema::table('phong', function (Blueprint $table) {
            $table->unsignedBigInteger('toa_nha_id')->nullable()->after('id');
            $table->foreign('toa_nha_id')->references('id')->on('toa_nhas')->nullOnDelete();
        });

        // Add to hopdong
        Schema::table('hopdong', function (Blueprint $table) {
            $table->unsignedBigInteger('toa_nha_id')->nullable()->after('id');
            $table->foreign('toa_nha_id')->references('id')->on('toa_nhas')->nullOnDelete();
        });

        // Add to hoadon
        Schema::table('hoadon', function (Blueprint $table) {
            $table->unsignedBigInteger('toa_nha_id')->nullable()->after('id');
            $table->foreign('toa_nha_id')->references('id')->on('toa_nhas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phong', function (Blueprint $table) {
            $table->dropForeign(['toa_nha_id']);
            $table->dropColumn('toa_nha_id');
        });

        Schema::table('hopdong', function (Blueprint $table) {
            $table->dropForeign(['toa_nha_id']);
            $table->dropColumn('toa_nha_id');
        });

        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropForeign(['toa_nha_id']);
            $table->dropColumn('toa_nha_id');
        });
    }
};
