<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class,'module_id')->orderBy('position');
    }
}
