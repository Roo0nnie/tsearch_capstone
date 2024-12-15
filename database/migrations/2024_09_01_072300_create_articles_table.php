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
        Schema::create('temp_files', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('adviser')->nullable();
            $table->string('department')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('publisher')->nullable();
            $table->string('publication_date')->nullable();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('awards')->nullable();
            $table->string('SDG')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pdf_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_files');
    }
};
