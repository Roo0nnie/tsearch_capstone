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
        Schema::create('imrads', function (Blueprint $table) {
            $table->id();
            // $table->string('title')->unique();
            $table->string('title')->nullable();
            $table->string('author');
            $table->string('adviser')->nullable();
            $table->string('department');
            $table->text('abstract');
            $table->string('publisher')->nullable();
            $table->string('publication_date');
            $table->text('keywords')->nullable();
            $table->string('location')>unique()->nullable();
            $table->string('awards')->nullable();
            $table->string('status')->default('published');
            $table->string('SDG')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pdf_file')->nullable();
            $table->dateTime('deleted_time')->nullable();
            $table->string('delete_by')->nullable();
            $table->dateTime('permanent_delete')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imrads');
    }
};