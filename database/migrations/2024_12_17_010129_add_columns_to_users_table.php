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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 25)->default('user');
            $table->string('last_name', 75)->default('');
            $table->string('middle_name', 75)->default('');
            $table->string('program_name', 255)->nullable();
            $table->string('team_name', 75)->nullable()->default('');
            $table->string('team_head', 255)->nullable()->default('');
            $table->string('team_head_phone', 200)->nullable()->default('');
            $table->string('parent_name', 200)->nullable()->default('');
            $table->string('child_name', 200)->nullable()->default('');
            $table->string('secondary_email', 200)->nullable()->default('');
            $table->string('grade', 200)->nullable()->default('');
            $table->string('gender', 5)->default('m');
            $table->boolean('member')->nullable()->default(false);
            $table->string('phone_home', 250)->nullable()->default('');
            $table->string('mobile', 250)->nullable()->default('');
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('city', 250)->nullable()->default('');
            $table->string('state', 10)->nullable()->default('');
            $table->string('zip', 250)->nullable()->default('');
            $table->string('country', 100)->nullable()->default('');
            $table->string('company', 250)->nullable()->default('');
            $table->tinyInteger('status')->default(0);
            $table->boolean('email_sent')->default(0);
            $table->boolean('csv_sent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'last_name',
                'middle_name',
                'program_name',
                'team_name',
                'team_head',
                'team_head_phone',
                'parent_name',
                'child_name',
                'secondary_email',
                'grade',
                'gender',
                'member',
                'phone_home',
                'mobile',
                'address1',
                'address2',
                'city',
                'state',
                'zip',
                'country',
                'company',
                'status',
                'email_sent',
                'csv_sent',
            ]);
        });
    }
};
