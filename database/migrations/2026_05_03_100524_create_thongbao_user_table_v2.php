<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thongbao_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thongbao_id')->constrained('thongbao')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('da_doc')->default(false);
            $table->timestamp('doc_luc')->nullable();
            $table->timestamps();

            $table->unique(['thongbao_id', 'user_id'], 'thongbao_user_unique');
            $table->index('da_doc', 'thongbao_user_da_doc_index');
            $table->index(['user_id', 'da_doc', 'created_at'], 'thongbao_user_user_doc_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thongbao_user');
    }
};
