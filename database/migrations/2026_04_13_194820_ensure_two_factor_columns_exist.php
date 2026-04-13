<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $columns = DB::select('SHOW COLUMNS FROM users LIKE "two_factor%"');

        if (empty($columns)) {
            DB::statement('ALTER TABLE users ADD two_factor_secret VARCHAR(255) NULL AFTER is_otp_verified');
            DB::statement('ALTER TABLE users ADD two_factor_enabled TINYINT(1) DEFAULT 0 AFTER two_factor_secret');
        }
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE users DROP COLUMN IF EXISTS two_factor_secret');
        DB::statement('ALTER TABLE users DROP COLUMN IF EXISTS two_factor_enabled');
    }
};
