<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $checkrole = explode(',', $role);
        if (in_array('admin', $checkrole)) {
            return redirect('/admin/list');
        } elseif(in_array('user', $checkrole)) {
            return redirect('/list');
        }

    }
}
