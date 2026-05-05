<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taisan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            
            $table->string('ten_tai_san');
            $table->string('ma_tai_san')->unique()->nullable();
            $table->unsignedInteger('so_luong')->default(1);
            $table->string('tinh_trang')->default('good'); // good, damaged, broken
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taisan');
    }
};
