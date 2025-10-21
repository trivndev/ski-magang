<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (!Schema::hasColumn('internships', 'deleted_at')) {
                $table->softDeletesTz()->after('updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (Schema::hasColumn('internships', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
