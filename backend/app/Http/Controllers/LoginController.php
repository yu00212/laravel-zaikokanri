<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ゲストログイン処理
    public function guestLogin()
    {
        $email = 'guest@test.com';
        $password = 'guest1234';
        $role = 'guest';

        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => $role])) {
            return redirect('/guest/list');
        }

        return redirect('/home');
    }

    public function index()
    {
        $role = Auth::user()->role;
        $checkrole = explode(',', $role);
        if (in_array('admin', $checkrole)) {
            return redirect('/admin/list');
        } elseif (in_array('user', $checkrole)) {
            return redirect('/list');
        }
    }
}
