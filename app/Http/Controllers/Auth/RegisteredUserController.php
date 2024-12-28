<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
//             Rules\Password::defaults()
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
//            'password' => bcrypt($request->password),
            'password' => Hash::make($request->password)
        ]);

 //       dd($user->email);

        if (!$user) {
            return redirect()->back()->with('error', 'Registration failed, Try again ... ');
        }
        else {
            return view('auth.login');
//            redirect()->route('login')->with('success', 'Registration successful, please log in ... ');
        }

        //event(new Registered($user));
//        Auth::login($user);
//        return redirect(RouteServiceProvider::HOME);

        //Auth::attempt(["email"=>"sad@asdasd", "password"=>"asdasd5454"])


    }
}
