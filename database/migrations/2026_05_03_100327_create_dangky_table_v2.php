<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dangky', function (Blueprint $table) {
            $table->id();
            // Nếu đã là user (đăng ký lại/gia hạn)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Thông tin Guest (PII tạm thời)
            $table->string('ho_ten')->nullable();
            $table->string('email')->nullable();
            $table->text('phone_encrypted')->nullable();
            $table->text('id_card_encrypted')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            
            // Nguyện vọng
            $table->foreignId('toa_nha_id')->constrained('toa_nha');
            $table->foreignId('loai_phong_id')->constrained('loai_phong');
            $table->foreignId('phong_id')->nullable()->constrained('phong');
            
            $table->enum('trang_thai', ['pending', 'approved_pending_payment', 'approved', 'completed', 'rejected', 'cancelled'])->default('pending');
            $table->text('ghi_chu')->nullable();
            $table->string('lookup_token')->unique(); // Để khách tra cứu kết quả
            $table->timestamp('token_expires_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['trang_thai', 'created_at'], 'dangky_status_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dangky');
    }
};
