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
            $table->unsignedTinyInteger('vocational_major_id')->after('job_category_id');
            $table->foreign('vocational_major_id')
                ->references('id')
                ->on('vocational_majors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship', function (Blueprint $table) {
            //
        });
    }
};
