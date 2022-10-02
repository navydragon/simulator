<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    use HasFactory;

    /**
     * Get the user_lessons that owns the UserModule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_lessons()
    {
        return $this->hasMany(UserLesson::class, 'user_module_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class,'module_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
