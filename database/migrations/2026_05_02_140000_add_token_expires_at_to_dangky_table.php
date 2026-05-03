<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('dangky', 'token_expires_at')) {
            return;
        }

        Schema::table('dangky', function (Blueprint $table) {
            $table->timestamp('token_expires_at')->nullable()->after('lookup_token');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('dangky', 'token_expires_at')) {
            return;
        }

        Schema::table('dangky', function (Blueprint $table) {
            $table->dropColumn('token_expires_at');
        });
    }
};
