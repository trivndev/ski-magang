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
        Schema::table('internships', function (Blueprint $table) {
            $table->unsignedTinyInteger('job_category')
                ->after('end_date');
            $table->foreign('job_category')
                ->references('id')
                ->on('job_categories')
                ->onDelete('cascade');
            $table->foreignId('author_id')
                ->after('job_category')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship', function (Blueprint $table) {
            $table->dropForeign(['job_category_id']);
            $table->dropForeign(['author_id']);
            $table->dropColumn('job_category_id');
            $table->dropColumn('author_id');
        });
    }
};
