<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function module()
    {
        return $this->belongsTo(Module::class,'module_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class,'lesson_id')->orderBy('position');
    }
}
