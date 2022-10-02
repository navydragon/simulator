<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\UserController;
use App\Models\TaskType;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/test', function (Request $request) {
        $data = "print('kek')";
        File::put(storage_path("script.py"),$data);
        $output_data = shell_exec('python '.storage_path("script.py"));
        // try {
        //     exec('python D:\xampp\laravel\simulator\storage\script.py',$output);
        // } catch (\Exception $e) {
        //     dd($e);
        // }

        $output_data = mb_convert_encoding($output_data, "utf-8", "windows-1251");
        return $output_data;
        // return response([
        //         'status' => 'error',
        //         'result' => mb_convert_encoding($output_data,'UTF-8','auto')]
        //         , 500);

// } catch (Throwable $e) {
        
//     return response([
//         'status' => 'error',
//         'error' => $e->getMessage()
//     ], 500);
// }
    return $output_data;
});

Route::post('/code/sql', function (Request $request){
    $task_type = TaskType::find($request->input('task_type_id'));
    $connection = $task_type->connection;
    if (!is_null($request->preCode))
    {
        $precode = DB::connection($connection)->select("SET NOCOUNT ON;".DB::raw($request->preCode));
    }
    try {
        $query = DB::connection($connection)->select(DB::raw($request->code));
    } catch (Throwable $e) {
        return response([
            'status' => 'error',
            'error' => $e->getMessage()
        ], 500);
    }
    if (!is_null($request->postCode))
    {
        $postcode = DB::connection($connection)->select("SET NOCOUNT ON;".DB::raw($request->postCode));
    }
    $obj =  new stdClass();
    if (count($query)> 0)
    {
        $obj->keys = array_keys((array)$query[0]);
    }else{
        $obj->keys = [];
    }
    $obj->status = 'success';
    $obj->results = $query;
    $obj->rowCount = count($query);
    $obj->colCount = count($obj->keys);
    return  $obj;
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registration_groups', [GroupController::class, 'registration_groups']);

Route::post('/password/forgot',[AuthController::class, 'forgot_password']);
Route::post('/password/reset',[AuthController::class, 'reset_password']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('/admin/courses', CourseController::class);
    Route::apiResource('/admin/modules', ModuleController::class);
    Route::apiResource('/admin/lessons', LessonController::class);
    Route::apiResource('/admin/tasks', TaskController::class);
    Route::get('/admin/task_types', [TaskController::class, 'task_types']);
    Route::apiResource('/admin/groups', GroupController::class);

    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/user_profile', [UserController::class, 'auth_profile']);
    Route::post('/update_profile', [UserController::class, 'update_profile']);

    Route::post('/code/try/sql', [CodeController::class, 'try_sql']);
    Route::post('/code/test/sql', [CodeController::class, 'test_sql']);
    Route::post('/code/reset', [CodeController::class, 'reset']);
    Route::post('learning/complete_lesson/{ul}', [LearningController::class, 'complete_lesson']);
    Route::post('learning/complete_module/{ul}', [LearningController::class, 'complete_module']);

    Route::get('/courses', [LearningController::class, 'course_catalog']);
    Route::get('/learnings/{learning_id}/lessons/{lesson_id}', [LearningController::class, 'show_lesson']);
    Route::get('/learnings/{id}', [LearningController::class, 'show']);
    

    Route::post('/learnings', [LearningController::class, 'add_learning']);
});
