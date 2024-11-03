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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adminId');
            $table->foreign('adminId')->references('id')->on('admins')->onDelete('cascade');
            $table->string('title')->unique();
            $table->text('content');
            $table->string('attachment')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('distributed_to');
            $table->string('activation')->default('Active');
            $table->boolean('manual_stop')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
