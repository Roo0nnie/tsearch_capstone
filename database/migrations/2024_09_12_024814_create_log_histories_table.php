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
    Schema::create('log_histories', function (Blueprint $table) {
        $table->id();
        $table->string('session_id');
        $table->string('user_code')->nullable();
        $table->string('name')->nullable();
        $table->string('user_type')->nullable();
        $table->timestamp('login')->nullable();
        $table->timestamp('logout')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_histories');
    }
};
