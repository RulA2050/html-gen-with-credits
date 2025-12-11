<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Email jadi opsional (nullable)
        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NULL;');

        Schema::table('users', function (Blueprint $table) {
            // pastikan sudah ada kolom phone_number di db

            // buat kolom terkait verifikasi nomor HP
            if (!Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone_number');
            }

            if (!Schema::hasColumn('users', 'phone_verification_code')) {
                $table->string('phone_verification_code', 6)->nullable()->after('phone_verified_at');
            }

            if (!Schema::hasColumn('users', 'phone_verification_expires_at')) {
                $table->timestamp('phone_verification_expires_at')->nullable()->after('phone_verification_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_phone_number_unique');
            $table->dropColumn([
                'phone_verified_at',
                'phone_verification_code',
                'phone_verification_expires_at',
            ]);
        });

        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL;');
    }
};
