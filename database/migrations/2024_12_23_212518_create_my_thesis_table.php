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
        Schema::create('my_thesis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imrad_id');
            $table->string('user_code');
            $table->string('user_type');
            $table->timestamps();
            $table->foreign('imrad_id')->references('id')->on('imrads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_thesis');
    }
};
