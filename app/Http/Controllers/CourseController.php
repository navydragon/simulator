<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\Admin\AdminCourseResource;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['modules']);
        return AdminCourseResource::collection($courses->get());
    }

    public function show(Course $course)
    {
        return new AdminCourseResource($course->loadMissing('modules.lessons'));
    }
    
    public function store(Request $request)
    {
        $course = new Course;
        $course->name = $request->input('course.name');
        $course->active = $request->input('course.active');
        $course->save();
        return new AdminCourseResource($course);
    }

    public function destroy (Course $course)
    {
        $course->delete();
        return $course->id;
        return response()->json([
            'status_code' => 200,
            'message' => 'Destroyed',
          ]);
    }
}
