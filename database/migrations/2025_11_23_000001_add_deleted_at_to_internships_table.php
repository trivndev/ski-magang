<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (!Schema::hasColumn('internships', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('internships', 'status_id')) {
            }
        });
    }

    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (Schema::hasColumn('internships', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
