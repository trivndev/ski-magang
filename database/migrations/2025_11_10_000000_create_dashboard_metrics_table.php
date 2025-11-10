<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dashboard_metrics', function (Blueprint $table) {
            $table->id();
            $table->timestamp('snapshot_at');
            $table->unsignedBigInteger('total_posts')->default(0);
            $table->unsignedBigInteger('posts_this_month')->default(0);
            $table->unsignedBigInteger('approved_count')->default(0);
            $table->unsignedBigInteger('rejected_count')->default(0);
            $table->unsignedBigInteger('pending_count')->default(0);
            $table->unsignedBigInteger('active_users')->default(0);
            $table->json('monthly_series');
            $table->json('monthly_user_series');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_metrics');
    }
};
