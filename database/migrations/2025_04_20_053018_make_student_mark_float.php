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
        Schema::table('results', function (Blueprint $table) {
            $table->float('student_mark')->change();
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->float('mark')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->integer('student_mark')->change();
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('mark')->change();
        });
    }
};
