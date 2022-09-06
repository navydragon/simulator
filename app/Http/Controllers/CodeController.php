<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTask;
use App\Models\UserLesson;
use App\Models\Task;
use App\Models\Learning;
use \Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Resources\Learning\UserTaskResource;

class CodeController extends Controller
{
    public function try_sql(Request $request)
    {
        $ut = UserTask::find($request->input('user_task_id'));
        $ut->current_code = $request->input('code');
        $ut->save();
        $connection = $ut->task->type->connection;
       $ch = $this->check_hack($request->code); 
       if ($ch != false)
       {
            return response([
            'status' => 'error',
            'error' => 'Ошибка при выполнении запроса: обнаружен запрещенный оператор '.$ch
            ], 500);
       }

        try {
            $code = strtolower($request->code);
            $query = DB::connection($connection)->select(DB::raw($code));
        } catch (Exception $e) {
            return response([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
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

        $ut->current_output = str_replace("'", "\'", json_encode($obj,JSON_UNESCAPED_UNICODE));
        $ut->save();
        return  $obj;
    }

    public function test_sql(Request $request)
    {
       $ch = $this->check_hack($request->code); 
       if ($ch != false)
       {
            return response([
            'status' => 'error',
            'error' => 'Ошибка при выполнении запроса: обнаружен запрещенный оператор '.$ch
            ], 500);
       }

        $ut = UserTask::find($request->input('user_task_id'));
        $ut->current_code = $request->input('code');
        $ut->save();
        $ul = UserLesson::find($ut->user_lesson_id);
        $t = Task::find($ut->task_id);

        $connection = $ut->task->type->connection;

        try {
            $code = strtolower($request->code);
            $query = DB::connection($connection)->select(DB::raw($code));
        } catch (Exception $e) {
            return response([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
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

        $ut->current_output = str_replace("'", "\'", json_encode($obj,JSON_UNESCAPED_UNICODE));
        $ut->save();
        $ro = DB::connection($connection)->select(DB::raw(strtolower($t->right_code)));

        if ($query == $ro) {
            $ut->is_completed = true;
            $ut->completed_at = date('Y-m-d H:i:s');
            $ut->save();
            if (!is_null($t->next_task_id))
            {
                $nt = Task::find($t->next_task_id);
                $learning = Learning::find($ut->learning_id);
                $user = $learning->user;
                $learning->add_user_task($user, $ul, $nt);
                $ul->current_task_id = $nt->id;
                $ul->save();
            }
            
        }
        $res = new stdClass();
        $res->output = $obj;
        $res->user_tasks = UserTaskResource::collection($ul->user_tasks);
        return  $res;
    }

    public function reset(Request $request)
    {
        $ut = UserTask::find($request->input('user_task_id'));
        $t =  Task::find ($ut->task_id);
        $ut->current_code = $t->start_code;
        $ut->current_output = "";
        $ut->save();
        return json_encode ($ut->current_code);
    }

    public function check_hack($code)
    {
        $code = strtolower($code);
        $rows = explode("\r\n",$code);
        foreach ($rows as $row) {
           $words = explode(" ",$row);
           if (in_array('update',$words)) { return 'UPDATE';}
           if (in_array('insert',$words)) { return 'INSERT';}
           if (in_array('drop',$words)) { return 'DROP';}
           if (in_array('delete',$words)) { return 'DELETE';}
           if (in_array('truncate',$words)) { return 'TRUNCATE';}
        }
        return false;
      
    }
}
