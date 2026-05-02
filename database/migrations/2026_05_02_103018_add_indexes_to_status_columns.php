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
        $this->addIndexIfNotExists('hoadon', 'trangthaithanhtoan');
        $this->addIndexIfNotExists('hopdong', 'trang_thai');
        $this->addIndexIfNotExists('dangky', 'trangthai');
    }

    private function addIndexIfNotExists(string $table, string $column): void
    {
        $indexName = "{$table}_{$column}_index";
        
        $exists = DB::select("
            SHOW INDEX FROM {$table} WHERE Key_name = '{$indexName}'
        ");

        if (empty($exists)) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->index($column);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropIndex(['trangthaithanhtoan']);
        });

        Schema::table('hopdong', function (Blueprint $table) {
            $table->dropIndex(['trang_thai']);
        });

        Schema::table('dangky', function (Blueprint $table) {
            $table->dropIndex(['trangthai']);
        });
    }
};
