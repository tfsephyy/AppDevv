<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToxicWordsTable extends Migration
{
    public function up()
    {
        Schema::create('toxic_words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->enum('type', ['word', 'phrase']);
            $table->enum('language', ['tagalog', 'english']);
            $table->timestamps();
            
            $table->index('word');
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('toxic_words');
    }
}
