<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstLessonToModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('first_lesson_id')->nullable();
            $table->foreign('first_lesson_id')->references('id')->on('lessons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign(['first_lesson_id']);
            $table->dropColumn(['first_lesson_id']);
        });
    }
}
