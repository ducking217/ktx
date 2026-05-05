<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sinhvien', function (Blueprint $table) {
            $table->string('anh_the_path')->nullable()->after('ngay_nhap_hoc');
            $table->string('anh_cccd_path')->nullable()->after('anh_the_path');
        });

        Schema::table('dangky', function (Blueprint $table) {
            $table->string('anh_the_path')->nullable()->after('dob');
            $table->string('anh_cccd_path')->nullable()->after('anh_the_path');
        });
    }

    public function down(): void
    {
        Schema::table('dangky', function (Blueprint $table) {
            $table->dropColumn(['anh_the_path', 'anh_cccd_path']);
        });

        Schema::table('sinhvien', function (Blueprint $table) {
            $table->dropColumn(['anh_the_path', 'anh_cccd_path']);
        });
    }
};

