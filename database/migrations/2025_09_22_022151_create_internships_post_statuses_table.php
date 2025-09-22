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
        Schema::create('internships_post_statuses', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary()->autoIncrement();
            $table->string('status');
            $table->string('status_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships_post_statuses');
    }
};
