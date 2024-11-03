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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('name');
            $table->string('user_code')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->timestamp('verification_code_expires_at')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->default('other');
            $table->string('type')->default('admin');
            $table->string('status')->default('inactive');
            $table->string('account_status')->default('active');
            $table->dateTime('deleted_time')->nullable();
            $table->string('delete_by')->nullable();
            $table->dateTime('permanent_delete')->nullable();
            $table->string('action')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
