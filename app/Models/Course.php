<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function modules()
    {
        return $this->hasMany(Module::class,'course_id')->orderBy('position');
    }

    public function learnings()
    {
        return $this->hasMany(Learning::class,'course_id');
    }

    public function user_learning($user_id)
    {
        return $this->hasMany(Learning::class,'course_id')->where('user_id',$user_id);
    }
}
