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
        Schema::table('admin_table', function (Blueprint $table) {
            $table->string('picture')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('admin_table', function (Blueprint $table) {
            $table->dropColumn('picture');
        });
    }
};
