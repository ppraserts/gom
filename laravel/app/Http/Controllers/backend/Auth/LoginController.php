<?php

namespace App\Http\Controllers\backend\Auth;
use App\Model\backend\Admin;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    private $rules = [
       'email' => 'required',
       'password' => 'required',
    ];
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLoginForm()
    {

        return view('backend/auth/login');
    }

    public function authenticate(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $password ], $remember))
        {

            return redirect()->intended('admin/userprofile');
        }
        else
        {
            return redirect()->intended('admin/login')->with('status', 'Invalid Login Credentials !');
        }
    }


    public function getLogout()
    {
        auth()->guard('admin')->logout();
        return redirect()->intended('admin/login');
    }

}
