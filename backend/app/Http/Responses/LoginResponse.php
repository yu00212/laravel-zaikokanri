<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role = \Auth::user()->role;

        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        switch ($role) {
            case 'admin':
                return redirect('/admin/list');
            case 'user':
                return redirect('/list');
            default:
                return redirect('/login');
        }
    }
}
