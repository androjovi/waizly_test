<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserVerify;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendEmail;

class RegisterController extends Controller
{

    function show() 
    {
        return view('auth.register');
    }

    function register(RegisterRequest $request)
    {   
        $validated = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 2,
            'status' => 0,
            'profile_picture' => ""
        ];

        $user = User::create($validated);

        $token = Str::random(64);

        $userVerify = [
            'user_id' => $user->id,
            'token' => $token,
        ];
        UserVerify::create($userVerify);

        $this->sendMailRegistration($request->email, $token);

        // auth()->login($user);

        return redirect('login')->with('success', 'Check your mailbox to verification');
    }

    function registerVerify($token)
    {
        $userVerify = UserVerify::where('token', $token)->first();

        if (!is_null($userVerify)){
            $user = User::find($userVerify->user_id);
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->status = 1;
            $user->save();

            return redirect('login')->with('success', 'Your email is verified. now you can login');
        }else{
            return redirect('login')->with('error', 'Your email is already verified, you can now login');
        }
    }

    function sendMailRegistration($to, $token)
    {
        dispatch(new SendEmail($to, 'register', $token));
    }
}
