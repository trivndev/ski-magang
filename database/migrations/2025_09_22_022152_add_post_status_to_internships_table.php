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
            $table->unsignedTinyInteger('status_id')->default(1)->after('end_date');
            $table->foreign('status_id')
                ->references('id')
                ->on('internships_post_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (Schema::hasColumn('internships', 'status_id')) {
                $table->dropForeign(['status_id']);
                $table->dropColumn('status_id');
            }
        });
    }
};
