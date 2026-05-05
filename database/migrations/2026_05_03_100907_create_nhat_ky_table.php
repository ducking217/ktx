<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhat_ky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('hanh_dong'); // create, update, delete
            $table->string('ten_model');
            $table->unsignedBigInteger('id_ban_ghi');
            $table->json('du_lieu_cu')->nullable();
            $table->json('du_lieu_moi')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at'], 'nhat_ky_user_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhat_ky');
    }
};
