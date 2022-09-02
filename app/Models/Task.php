<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::deleted(function ($task) {
           $below_tasks = Task::where('lesson_id',$task->lesson_id)->where('position', '>',$task->position)->get();
           foreach ($below_tasks as $item) {
             $item->position -= 1;
             $item->save();
           }
        });
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }

    public function type()
    {
        return $this->belongsTo(TaskType::class,'task_type_id');
    }
}
