<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskType;
use App\Models\Task;
use App\Http\Resources\TaskTypeResource;
use App\Http\Resources\Admin\AdminTaskResource;
class TaskController extends Controller
{
    public function task_types()
    {
        return TaskTypeResource::collection(TaskType::all());
    }

    public function store(Request $request)
    {
        $task = new Task;
        $task->description = $request->input('task.description');
        $task->task_type_id = $request->input('task.typeId');
        $task->start_code = $request->input('task.startCode');
        $task->right_code = $request->input('task.rightCode');
        $task->pre_code = $request->input('task.preCode');
        $task->post_code = $request->input('task.postCode');
        $task->right_output = str_replace("'", "\'", json_encode($request->input('task.rightOutput'),JSON_UNESCAPED_UNICODE));
        $task->lesson_id = $request->input('lessonId');
        $task->active = $request->input('task.active');
        $task->position = Task::where('lesson_id',$request->input('lessonId'))->count() + 1;
        $task->save();
        return new AdminTaskResource($task);
    }
    public function update(Request $request,Task $task)
    {
        $task->description = $request->input('task.description');
        $task->task_type_id = $request->input('task.typeId');
        $task->start_code = $request->input('task.startCode');
        $task->pre_code = $request->input('task.preCode');
        $task->post_code = $request->input('task.postCode');
        $task->right_code = $request->input('task.rightCode');
        $task->right_output = str_replace("'", "\'", json_encode($request->input('task.rightOutput'),JSON_UNESCAPED_UNICODE));
        $task->active = $request->input('task.active');
        $task->save();
        return new AdminTaskResource($task);
    }

    public function destroy (Task $task)
    {
        $id = $task->id;
        $task->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Destroyed',
            'id' => $id
          ]);
    }
}
