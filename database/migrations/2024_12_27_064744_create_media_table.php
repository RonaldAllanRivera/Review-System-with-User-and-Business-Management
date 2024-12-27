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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_path')->nullable(); // Add this if it's missing
            $table->string('file_name')->nullable(); // Allow null values
            $table->string('alt_text')->nullable(); // Allow null values
            $table->string('caption')->nullable(); // Allow null values
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('file_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('media');
        Schema::enableForeignKeyConstraints();
    }


};
