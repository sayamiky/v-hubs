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
        Schema::create('timeline_medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('timeline_post_id');
            $table->foreign('timeline_post_id')->references('id')->on('timeline_posts')->onDelete('cascade');
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_medias');
    }
};
