<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        $guard = $request->guard;
        if(\Auth::guard($guard)->attempt($credentials)) {
            if ($guard == "admin-higher") {
                return redirect()->route('admin-home');
            }
            if ($guard == "user-higher") {
                return redirect()->route('home');
            }
        }
        return back()->withErrors([ 'auth' => ['認証に失敗しました']]);
    }
}
