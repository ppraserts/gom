<?php

namespace App\Http\Controllers\frontend\Auth;

use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CaptchaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function checkCaptcha()
    {

        $rules = array(
            'CaptchaCode' => 'required|valid_captcha',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('status' => 'false', 'validate' => $validator));
        }
        return response()->json(array('status' => 'true'));

    }

}
