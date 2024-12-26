<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->enum('business_type', ['Business', 'Under Corporate'])->default('Business'); // Restrict to specific options
            $table->string('slug', 255);
            $table->string('business_name', 256)->default('');
            $table->text('tagline')->nullable();
            $table->string('business_address1', 256)->nullable();
            $table->string('business_address2', 256)->nullable();
            $table->string('business_city', 256)->nullable();
            $table->string('business_state', 45)->nullable();
            $table->string('business_zip', 45)->nullable();
            $table->string('business_contact_first_name', 256)->nullable();
            $table->string('business_contact_last_name', 256)->nullable();
            $table->string('business_contact_email', 255)->nullable();
            $table->string('business_contact_email_cc', 255)->nullable();
            $table->string('business_contact_email_bcc', 255)->nullable();
            $table->string('business_contact_phone', 100)->nullable();
            $table->char('header_color', 7)->nullable();
            $table->char('border_color', 7)->nullable();
            $table->enum('immediate_report', ['0', '1'])->default('0');
            $table->enum('immediate_report_rating1', ['0', '1'])->default('0');
            $table->enum('immediate_report_rating2', ['0', '1'])->default('0');
            $table->enum('immediate_report_rating3', ['0', '1'])->default('0');
            $table->enum('immediate_report_rating4', ['0', '1'])->default('0');
            $table->enum('immediate_report_rating5', ['0', '1'])->default('0');
            $table->enum('special_offers', ['0', '1'])->default('0');
            $table->enum('weekly_report', ['0', '1'])->default('0');
            $table->enum('weekly_report_flat', ['0', '1'])->default('0');
            $table->enum('monthly_report', ['0', '1'])->default('0');
            $table->string('youtube_link', 255)->nullable();
            $table->enum('youtube_autoplay', ['0', '1'])->default('0');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

