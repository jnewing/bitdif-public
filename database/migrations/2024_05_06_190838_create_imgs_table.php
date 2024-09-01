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
        Schema::create('imgs', function (Blueprint $table) {
            $table->id();
            $table->string('oid')->unique();
            $table->foreignId('user_id')->constrained();
            $table->string('original_name');
            $table->string('original_extension');
            $table->string('file_name');
            $table->string('thumbnail_name')->nullable();
            $table->string('path');
            $table->string('public_path');
            $table->string('mime_type');
            $table->bigInteger('file_size');
            $table->softDeletes('deleted_at', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imgs');
    }
};
