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
        Schema::create('invalid_admins', function (Blueprint $table) {
            $table->id();
            // $table->string('profile')->nullable();
            $table->string('name')->nullable();
            $table->string('user_code')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->string('type')->default('admin');
            $table->string('status')->default('offline');
            $table->string('account_status')->default('blocked');
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invalid_admins');
    }
};
