<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baohong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            $table->foreignId('giuong_id')->nullable()->constrained('giuong')->nullOnDelete();
            
            $table->text('mo_ta');
            $table->string('hinh_anh_path')->nullable();
            $table->enum('trang_thai', ['pending', 'processing', 'done', 'rejected'])->default('pending');
            $table->enum('muc_do', ['low', 'medium', 'high'])->default('low');
            
            $table->unsignedBigInteger('chi_phi_du_kien')->default(0);
            $table->enum('nguoi_chiu_phi', ['ktx', 'sinhvien'])->default('ktx');
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['trang_thai', 'created_at'], 'baohong_status_created_index');
            $table->index(['phong_id', 'trang_thai', 'created_at'], 'baohong_phong_status_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baohong');
    }
};
