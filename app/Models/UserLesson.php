<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    use HasFactory;


    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }

    public function user_module()
    {
        return $this->belongsTo(UserModule::class, 'user_module_id');
    }

    public function user_tasks()
    {
        return $this->hasMany(UserTask::class,'user_lesson_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }

}
