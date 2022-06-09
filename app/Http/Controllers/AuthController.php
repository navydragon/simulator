<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $user = new User();
        $user->lastname = $request->input('user.lastname');
        $user->firstname = $request->input('user.firstname');
        $user->fathername = $request->input('user.fathername');
        $user->email = $request->input('user.email');
        $user->name = $request->input('user.lastname')." ".$request->input('user.firstname')." ".$request->input('user.fathername');
        $user->password = Hash::make($request->input('user.password'));
        $user->save();
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
              'email' => 'required',
              'password' => 'required'
            ]);
            
            $user = User::where('email', $request->email)->first();
            
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response('Указан неверный email или пароль', 503);
            }
            
            Auth::login($user);
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
              'status_code' => 200,
              'access_token' => $tokenResult,
              'token_type' => 'Bearer',
            ]);
        } catch (Exception $error) {
            return response()->json([
              'status_code' => 500,
              'message' => 'Error in Login',
              'error' => $error,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        Auth::guard('web')->logout();
        return response()->json([
          'status_code' => 200,
          'message' => 'Logged out',
        ]);
    }

    public function user(Request $request)
    {
        dd("KEK");
        return "EKE";
    }
}
