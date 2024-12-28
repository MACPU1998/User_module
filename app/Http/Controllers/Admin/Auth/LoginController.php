<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function login()
    {
        return view("admin.auth.login");
    }

    public function loginAction(LoginRequest $request)
    {
        if(Auth::guard("admin")->attempt($request->validated()))
            return redirect(route("admin.dashboard"));
        return back()->with("error",__("message.error_login"));
    }

    public function logout()
    {
        session()->forget("selected_role");
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        Cache::flush();
        return redirect('/');
    }
}
