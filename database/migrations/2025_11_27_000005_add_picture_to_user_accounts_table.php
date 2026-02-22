<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPictureToUserAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->string('picture')->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->dropColumn('picture');
        });
    }
}
