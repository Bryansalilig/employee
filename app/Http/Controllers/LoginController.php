<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        return $this->authFields(['email', 'email2', 'email3'], $request->email, $request->password);
    }

    public function authFields($arrayIndex, $field, $password)
    {
        foreach($arrayIndex as $index) {
            if (Auth::attempt([ $index => $field, 'password' => $password])) {
                $user = User::where($index, '=', $field);
                if ($user->count() > 0) {
                    Auth::login($user->first());
                    return redirect()->intended('/');
                }
            }
        }
        return back()->withErrors(['email' => "Incorrect email and password combination!"]);
    }
}
