<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Model\frontend\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Shop;

class LoginController extends Controller
{
    private $rules = [
        'email' => 'required|email',
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
        return view('frontend/auth/login');
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, $this->rules);
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (auth()->guard('user')->attempt(['email' => $email, 'password' => $password, 'is_active' => 1], $remember)) {
            $user = auth()->guard('user')->user();

            $shop = Shop::where('user_id', $user->id)->first();

            if ($shop != null) {
                $shop_setting = array(
                    'theme' => $shop->theme,
                    'shop_name' => $shop->shop_name,
                );
                session(['shop' => $shop_setting]); // Save to session
            }else{
                session(['shop' => null]);
            }

             return redirect()->intended('user/userprofiles');
        } else {
            return redirect()->intended('user/login')->with('status', 'Invalid Login Credentials !');
        }
    }


    public function getLogout()
    {
        auth()->guard('user')->logout();
        session()->forget('carts');
        session()->flush();
        return redirect()->intended('user/login');
    }

}
