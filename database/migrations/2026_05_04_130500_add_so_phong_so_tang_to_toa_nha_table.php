<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toa_nha', function (Blueprint $table) {
            $table->unsignedInteger('so_phong')->nullable()->after('mo_ta');
            $table->unsignedInteger('so_tang')->nullable()->after('so_phong');
        });

        $stats = DB::table('phong')
            ->selectRaw('toa_nha_id, COUNT(*) as so_phong, MAX(tang) as so_tang')
            ->whereNull('deleted_at')
            ->groupBy('toa_nha_id')
            ->get();

        foreach ($stats as $row) {
            DB::table('toa_nha')
                ->where('id', (int) $row->toa_nha_id)
                ->update([
                    'so_phong' => (int) ($row->so_phong ?? 0),
                    'so_tang' => (int) ($row->so_tang ?? 0),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('toa_nha', function (Blueprint $table) {
            $table->dropColumn(['so_phong', 'so_tang']);
        });
    }
};
