<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth::attempt($credentials)) {
            $user = auth::user();
            $token = $user->createtoken((string)$user->id);

            return response()->json(['user' => $user, 'token' => $token]);
        }

//        if (auth::guard('web')->attempt($credentials)) {
//            session()->regenerate();
//            $user = auth::user();
//
//            return response()->json($user);
//        }

        return response()->json([
            'errors' => [
                'email' => 'the provided credentials do not match our records.',
                'emailfs' => bcrypt('admin'),

            ],
        ], 422);
    }

    public function fasdfds()
    {
        return response()->json([
            'sadg' => 1,
        ]);
    }
}
