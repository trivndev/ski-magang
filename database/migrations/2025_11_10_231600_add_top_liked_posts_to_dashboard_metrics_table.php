<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dashboard_metrics', function (Blueprint $table) {
            $table->json('top_liked_posts')->nullable()->after('monthly_user_series');
        });
    }

    public function down(): void
    {
        Schema::table('dashboard_metrics', function (Blueprint $table) {
            $table->dropColumn('top_liked_posts');
        });
    }
};
