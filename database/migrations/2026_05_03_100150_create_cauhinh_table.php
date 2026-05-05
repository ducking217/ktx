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
        Schema::create('cauhinh', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique()->comment('Tên cấu hình');
            $table->text('giatri')->nullable()->comment('Giá trị cấu hình');
            $table->string('nhom')->nullable()->comment('Nhóm cấu hình');
            $table->text('mo_ta')->nullable()->comment('Mô tả cấu hình');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cauhinh');
    }
};
