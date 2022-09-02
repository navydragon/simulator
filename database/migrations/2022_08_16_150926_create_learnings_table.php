<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->datetime('assigned_at',$precision = 0);
            $table->boolean('is_completed')->default(0);
            $table->datetime('completed_at',$precision = 0)->nullable();
            $table->unsignedBigInteger('current_module_id');
            $table->foreign('current_module_id')->references('id')->on('modules');
            $table->unsignedBigInteger('current_lesson_id');
            $table->foreign('current_lesson_id')->references('id')->on('lessons');
            $table->integer('percentage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learnings');
    }
}
