<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Http\Resources\Admin\AdminLessonResource;
class LessonController extends Controller
{
    public function store(Request $request)
    {
        $lesson = new Lesson;
        $lesson->name = $request->input('lesson.name');
        $lesson->module_id = $request->input('moduleId');
        $lesson->active = $request->input('lesson.active');
        $lesson->position = Lesson::where('module_id',$request->input('moduleId'))->count() + 1;
        $lesson->save();
        return new AdminLessonResource($lesson);
    }

    public function update(Lesson $lesson, Request $request)
    {
        $lesson->text = $request->input('lesson.text');
        $lesson->save();
    }

    public function show(Lesson $lesson)
    {
        return new AdminLessonResource($lesson->loadMissing('tasks'));
    }
}
