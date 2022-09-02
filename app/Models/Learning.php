<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    public function scopeUserLearning ($query, $user_id)
    {
        $query->where('user_id',$user_id);
    }

    public function user_modules()
    {
        return $this->hasMany(UserModule::class,'learning_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function add_user_module(User $user,Module $module)
    {
        $um = new UserModule;
        $um->learning_id = $this->id;
        $um->user_id = $user->id;
        $um->module_id = $module->id;
        $um->current_lesson_id = $module->first_lesson_id;
        
        $um->assigned_at = date('Y-m-d H:i:s');
        $um->save();
        $lesson = Lesson::find($module->first_lesson_id);
        $this->add_user_lesson($user,$um,$lesson);
        return $um;
    }

    public function add_user_lesson(User $user, UserModule $user_module, Lesson $lesson)
    {
        $ul = new UserLesson;
        $ul->learning_id = $this->id;
        $ul->user_id = $user->id;
        $ul->lesson_id = $lesson->id;
        $ul->user_module_id = $user_module->id;
        $ul->assigned_at = date('Y-m-d H:i:s');
        $ul->save();
        $lesson_tasks = $lesson->tasks;
        if (count($lesson_tasks) > 0)
        {

            $ul->current_task_id = $lesson_tasks[0]->id;
            $ul->save();
            $this->add_user_task($user,$ul,$lesson_tasks[0]);
        }
       
    }

    public function add_user_task(User $user, UserLesson $user_lesson, Task $task)
    {
        $ut = new UserTask;
        $ut->learning_id = $this->id;
        $ut->user_id = $user->id;
        $ut->task_id = $task->id;
        $ut->user_lesson_id = $user_lesson->id;
        $ut->assigned_at = date('Y-m-d H:i:s');
        $ut->current_code = $task->start_code;
        $ut->save();
    }
}
