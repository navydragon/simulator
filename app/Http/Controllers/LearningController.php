<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Learning\CourseResource;
use App\Http\Resources\Learning\LearningResource;
use App\Http\Resources\Learning\UserLessonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\UserModule;
use App\Models\UserLesson;

use App\Models\Learning;

class LearningController extends Controller
{
    public function course_catalog()
    {
        $courses = Course::where('active',1)
            ->with(['learnings' => function ($q) {$q->userLearning(Auth::user()->id);}]);
        return CourseResource::collection($courses->get());
    }

    public function add_learning(Request $request)
    {
        $learn = Learning::where('user_id',Auth::user()->id)->where('course_id',$request->course_id)->get();
        if (count($learn) != 0) 
        {
            return response([
                'message'=> "Вы уже записаны на данный курс"
            ], 403);
        }
        $course = Course::find($request->course_id);
        $module = Module::find($course->first_module_id);
        $learn = new Learning;
        $learn->user_id = Auth::user()->id;
        $learn->course_id = $request->course_id;
        $learn->assigned_at = date('Y-m-d H:i:s');
        $learn->current_module_id = $course->first_module_id;
        $learn->current_lesson_id = $module->first_lesson_id;
        $learn->save();

        $um = $learn->add_user_module(Auth::user(),$module);
        
        return new LearningResource($learn);
    }

    public function show(Learning $id)
    {
        return new LearningResource($id->loadMissing(['course.modules','user_modules']));
    }

    public function show_lesson(Learning $learning_id,Lesson $lesson_id)
    {
        $res = UserLesson::where('learning_id',$learning_id->id)->where('lesson_id',$lesson_id->id)->where('user_id',Auth::user()->id)->get()->first();
        return new UserLessonResource($res->loadMissing(['learning.course.modules.lessons','learning.user_modules.user_lessons','lesson.tasks']));
    }

    public function complete_lesson(UserLesson $ul)
    {
        $lesson = $ul->lesson;
        if ($ul->is_completed == false)
        {
            $ul->is_completed = true;
            $ul->completed_at = date('Y-m-d H:i:s');
            $ul->save();
            
            if ($lesson->next_lesson_id != null)
            {
                $um = $ul->user_module;
                $um->current_lesson_id = $lesson->next_lesson_id;
                $um->save();
                
                $learning = $ul->learning;
                $user = $ul->user;
                $next_lesson = Lesson::find($lesson->next_lesson_id);
                $learning->add_user_lesson($user, $um, $next_lesson);
            }
        }
        if ($lesson->next_lesson_id != null)
        {
            return $lesson->next_lesson_id;
        }else{
            return null;
        }
    }

    public function complete_module(UserLesson $ul)
    {
        $um = $ul->user_module;
        $module = $um->module;

        if ($ul->is_completed == false)
        {
            $this->complete_lesson($ul);
        }
        
        
        if ($um->is_completed == false)
        {
            $um->is_completed = true;
            $um->completed_at = date('Y-m-d H:i:s');
            $um->save();
            if ($module->next_module_id != null)
            {
                $next_module = Module::find($module->next_module_id);
                $learning = $ul->learning;
                $learning->current_module_id = $next_module->id;
                $learning->current_lesson_id = $next_module->first_lesson_id;
                $learning->save();
                $user = $ul->user;
                $learning->add_user_module($user, $next_module);
            }
        }
        return "ok";
    }

    public function force_next_module(Module $module)
    {
        $ums = UserModule::where('module_id',$module->id)->where('is_completed',1);
        if (!is_null($module->next_module_id))
        {
            $next_module = Module::find($module->next_module_id);
            foreach ($ums as $um)
            {
                $learning = Learning::find($um->learning_id);
                $learning->current_module_id = $next_module->id;
                $learning->current_lesson_id = $next_module->first_lesson_id;
                $learning->save();
                $user = $um->user;
                $learning->add_user_module($user, $next_module);
            }
            
        }
    }
}
