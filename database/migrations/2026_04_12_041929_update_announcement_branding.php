<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('announcements')
            ->where('title', 'like', '%EduCorner%')
            ->update([
                'title' => DB::raw("REPLACE(title, 'EduCorner', 'ProGuidePh')"),
                'content' => DB::raw("REPLACE(content, 'EduCorner', 'ProGuidePh')"),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
