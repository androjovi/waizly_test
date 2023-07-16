<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    function __construct() {

    }

    function show() {
        return view('auth.login');
    }

    function login(LoginRequest $request) {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)){
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);        
        Auth::Login($user);
        if (Auth::User($user)->status == 3){
            $this->removeAuth();
            return redirect()->to('login')->withErrors('Email not yet verified, please check your email');
        }

        if (Auth::User()->status == 0){
            $this->removeAuth();
            return redirect()->to('login')->withErrors('Email not verified, check your mailbox');
        }

        if (Auth::User()->role == 1){
            return redirect()->intended('productList');
        }elseif(Auth::User()->role == 2){
            return redirect()->intended('product');
        }else{
            $this->removeAuth();
            return redirect()->to('login')->withErrors('Role not found, ask administrator');
        }
    }
    public function logout()
    {
        $this->removeAuth();
        return redirect('login');
    }

    function removeAuth()
    {
        Session::flush();
        Auth::Logout();
    }
}
