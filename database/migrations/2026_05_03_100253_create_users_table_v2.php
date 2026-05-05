<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('vaitro', ['guest', 'sinhvien', 'admin'])->default('sinhvien')->index();
            $table->boolean('is_active')->default(true);

            // PII (Encrypted/Sensitive)
            $table->text('phone')->nullable();
            $table->string('phone_blind_index')->nullable()->index();
            
            $table->text('id_card')->nullable(); // CCCD
            $table->string('id_card_blind_index')->nullable()->index();
            
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable(); // Date of Birth
            $table->text('address')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
