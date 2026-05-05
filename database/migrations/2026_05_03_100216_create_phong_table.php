<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toa_nha_id')->constrained('toa_nha')->cascadeOnDelete();
            $table->foreignId('loai_phong_id')->constrained('loai_phong')->cascadeOnDelete();
            $table->string('ten_phong');
            $table->unsignedInteger('tang');
            $table->string('gioi_tinh_han_che')->default('any'); // male, female, any
            $table->string('trang_thai')->default('active'); // active, maintenance, full
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['toa_nha_id', 'ten_phong']); // Tên phòng duy nhất trong 1 tòa nhà
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phong');
    }
};
