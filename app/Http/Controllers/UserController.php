<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function auth_profile()
    {
        return new ProfileResource(Auth::user());
    }

    public function update_profile(Request $request)
    {
        $user = User::find($request->input('user.id'));
        $user->lastname = $request->input('user.lastname');
        $user->firstname = $request->input('user.firstname');
        $user->fathername = $request->input('user.fathername');
        $user->email = $request->input('user.email');
        $user->name = $request->input('user.lastname')." ".$request->input('user.firstname')." ".$request->input('user.fathername');
        $user->group_id = $request->input('user.group_id');
        if ($request->input('user.group_id') == 'null') 
        {
            $user->group_id = null;
        }
        $user->save();
        return new ProfileResource($user);
    }
}
