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
            $table->foreignId('author_id')
                ->after('end_date')
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            if (Schema::hasColumn('internships', 'author_id')) {
                try {
                    $table->dropForeign(['author_id']);
                } catch (\Throwable $e) {
                    // ignore if foreign key does not exist
                }
                $table->dropColumn('author_id');
            }
        });
    }
};
