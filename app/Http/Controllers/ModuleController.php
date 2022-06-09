<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Http\Resources\Admin\AdminModuleResource;

class ModuleController extends Controller
{
    public function store(Request $request)
    {
        $module = new Module;
        $module->name = $request->input('module.name');
        $module->course_id = $request->input('courseId');
        $module->active = $request->input('module.active');
        $module->position = Module::where('course_id',$request->input('courseId'))->count() + 1;
        $module->save();
        return new AdminModuleResource($module);
    }

    public function show(Module $module)
    {
        return new AdminModuleResource($module->loadMissing('lessons.tasks'));
    }
}
