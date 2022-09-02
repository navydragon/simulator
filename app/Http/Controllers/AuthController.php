<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
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
        $user->group_id = $request->input('user.group_id');
        $user->save();
        Auth::login($user);
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return response()->json([
          'status_code' => 200,
          'access_token' => $tokenResult,
          'token_type' => 'Bearer',
        ]);
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
       // $request->user()->currentAccessToken()->delete();
       $request->user()->tokens()->delete();
       Auth::guard('web')->logout();
        return response()->json([
          'status_code' => 200,
          'message' => 'Logged out',
        ]);
    }

    public function user(Request $request)
    {
      $res = $request->user();
        return $res ? $res : null;
      }

      public function forgot_password(Request $request)
      {
        $request->validate([
          'email' => 'required|email',
      ]);

      $status = Password::sendResetLink(
          $request->only('email')
      );

      if ($status == Password::RESET_LINK_SENT) {
          return [
              'status' => 'Ссылка на сброс пароля направлена на почту!'
          ];
      }

      return response([
        'message'=> [trans($status)],
      ], 500);
    }

    public function reset_password(Request $request)
    {
      $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required'],
      ]);

      $status = Password::reset(
          $request->only('email', 'password', 'token'),
          function ($user) use ($request) {
              $user->forceFill([
                  'password' => Hash::make($request->password),
                  'remember_token' => Str::random(60),
              ])->save();

              $user->tokens()->delete();

              event(new PasswordReset($user));
          }
      );

      if ($status == Password::PASSWORD_RESET) {
          return response([
              'message'=> 'Password reset successfully'
          ]);
      }

      return response([
          'message'=> __($status)
      ], 500);
      }
}
