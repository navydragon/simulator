<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_id');
            $table->foreign('learning_id')->references('id')->on('learnings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->unsignedBigInteger('current_lesson_id');    
            $table->foreign('current_lesson_id')->references('id')->on('lessons');

            $table->datetime('assigned_at',$precision = 0);
            $table->boolean('is_completed')->default(0);
            $table->datetime('completed_at',$precision = 0)->nullable();
            
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
        Schema::dropIfExists('user_modules');
    }
}
