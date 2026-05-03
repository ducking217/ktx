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
        Schema::table('sinhvien', function (Blueprint $table) {
            $table->date('ngaysinh')->nullable()->after('lop');
            $table->text('diachi')->nullable()->after('ngaysinh');
            $table->string('dantoc')->nullable()->default('Kinh')->after('diachi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sinhvien', function (Blueprint $table) {
            $table->dropColumn(['ngaysinh', 'diachi', 'dantoc']);
        });
    }
};
