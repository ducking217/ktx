<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toa_nha', function (Blueprint $table) {
            $table->id();
            $table->string('ten_toa_nha')->unique();
            $table->string('ma_toa_nha')->unique();
            $table->enum('gioi_tinh', ['male', 'female', 'any'])->default('any');
            $table->string('dia_chi')->nullable();
            $table->text('mo_ta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toa_nha');
    }
};
