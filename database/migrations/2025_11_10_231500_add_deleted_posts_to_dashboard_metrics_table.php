<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dashboard_metrics', function (Blueprint $table) {
            if (!Schema::hasColumn('dashboard_metrics', 'deleted_posts')) {
                $table->unsignedBigInteger('deleted_posts')->default(0)->after('active_users');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dashboard_metrics', function (Blueprint $table) {
            if (Schema::hasColumn('dashboard_metrics', 'deleted_posts')) {
                $table->dropColumn('deleted_posts');
            }
        });
    }
};
