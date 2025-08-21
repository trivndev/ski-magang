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
        Schema::create('internships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('job_title', 255);
            $table->string('company', 255);
            $table->string('location', 255);
            $table->string('job_description');
            $table->string('requirements');
            $table->string('benefits')->nullable();
            $table->string('contact_email', 255);
            $table->string('contact_phone', 20);
            $table->string('contact_name', 255);
            $table->dateTimeTz('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
