<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->timestamp('ngay_thanh_toan')->nullable()->after('trangthaithanhtoan');
        });

        // Backfill data: set ngay_thanh_toan = updated_at for paid invoices
        DB::table('hoadon')
            ->where('trangthaithanhtoan', 'paid')
            ->update(['ngay_thanh_toan' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropColumn('ngay_thanh_toan');
        });
    }
};
