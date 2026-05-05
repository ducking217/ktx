<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng admin đã bị loại bỏ trong DB v2 mới.
    }

    public function down(): void
    {
        // No-op để giữ tính tương thích chuỗi migration cũ.
    }
};
