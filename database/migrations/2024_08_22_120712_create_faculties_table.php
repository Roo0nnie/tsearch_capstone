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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('name');
            $table->string('user_code')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->date('birthday');
            $table->string('password');
            $table->string('type')->default('faculty'); // role
            $table->string('status')->default('offline'); // online or offline
            $table->string('account_status')->default('active'); // active blocked or suspended
            $table->rememberToken();
            $table->timestamps();
            // $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
