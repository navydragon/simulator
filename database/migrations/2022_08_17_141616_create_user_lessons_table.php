<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_id');
            $table->foreign('learning_id')->references('id')->on('learnings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_module_id');
            $table->foreign('user_module_id')->references('id')->on('user_modules');
            $table->unsignedBigInteger('current_task_id')->nullable();    
            $table->foreign('current_task_id')->references('id')->on('tasks');

            $table->datetime('assigned_at',$precision = 0);
            $table->boolean('is_completed')->default(0);
            $table->datetime('completed_at',$precision = 0)->nullable();
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
        Schema::dropIfExists('user_lessons');
    }
}
