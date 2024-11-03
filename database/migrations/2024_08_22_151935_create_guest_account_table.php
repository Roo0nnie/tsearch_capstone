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
        Schema::create('guest_account', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('name');
            $table->string('user_code')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable();
            $table->string('type')->default('user');
            $table->string('age')->nullable();
            $table->string('gender')->default('other');
            $table->string('status')->default('Active');
            $table->string('account_status')->default('active');
            $table->dateTime('deleted_time')->nullable();
            $table->string('delete_by')->nullable();
            $table->dateTime('permanent_delete')->nullable();
            $table->string('action')->nullable();
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
        Schema::dropIfExists('guest_account');
    }
};
