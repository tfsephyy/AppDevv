<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id');
            $table->string('user_id');
            $table->timestamps();

            $table->unique(['journal_id', 'user_id']);
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_likes');
    }
};
