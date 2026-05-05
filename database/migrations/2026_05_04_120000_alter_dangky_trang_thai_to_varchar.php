<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE `dangky` MODIFY `trang_thai` VARCHAR(50) NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE `dangky` MODIFY `trang_thai` ENUM('pending','approved_pending_payment','approved','completed','rejected','cancelled') NOT NULL DEFAULT 'pending'");
    }
};

