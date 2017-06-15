<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Model\frontend\User;
use App\UserStandard;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Amphur;
use App\Province;
use App\District;
use App\Standard;

class RegisterController extends Controller
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

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    public function getRegisterForm()
    {
        $standards = Standard::all();
        $provinceItem = Province::orderBy('PROVINCE_NAME', 'ASC')
            ->get();
        return view('frontend/auth/register', compact('provinceItem', 'standards'));
    }

    public function getCompanyRegisterForm()
    {
        $standards = Standard::all();
        $provinceItem = Province::orderBy('PROVINCE_NAME', 'ASC')
            ->get();
        return view('frontend/auth/companyregister', compact('provinceItem', 'standards'));
    }

    public function getChooseRegisterForm()
    {
        return view('frontend/chooseregister');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  request $request
     * @return User
     */
    protected function saveRegisterForm(Request $request)
    {

        $rules = array(
            'iwantto' => 'required',
            'users_idcard' => 'required|min:13|max:20',
            'users_firstname_th' => 'required|max:255',
            'users_lastname_th' => 'required|max:255',
            'users_dateofbirth' => 'required|date_format:Y-m-d',
            'users_province' => 'required',
            'users_city' => 'required',
            'users_district' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'CaptchaCode' => 'required|valid_captcha',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect('user/register')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $user = User::registeruser($input);


        $sendemailTo = $request->email;
        $sendemailFrom = env('MAIL_USERNAME');

        $data = array(
            'fullname' => $request->users_firstname_th . " " . $request->users_lastname_th
        );

        /*
        Mail::send('emails.register', $data, function ($message) use($request, $sendemailTo, $sendemailFrom)
        {
            $message->from($sendemailFrom
                    , "DGTFarm");
            $message->to($sendemailTo)
                    ->subject("DGTFarm : ".trans('messages.email_subject_newregister'));

        });
        */

        if ($user->id) {
            $arr_checked_user_standards = Input::get('users_standard');
            if (is_array($arr_checked_user_standards)) {
                foreach ($arr_checked_user_standards as $standard_id) {
                    UserStandard::create([
                        'user_id' => $user->id,
                        'standard_id' =>$standard_id
                    ]);
                }
            }
            return redirect('user/login')->with('status', trans('messages.registercomplete'));
        } else {
            return redirect('user/register')->with('status', 'User not register. Please try again');
        }

    }

    protected
    function saveCompanyRegisterForm(Request $request)
    {
        $rules = array(
            'iwantto' => 'required',
            'users_taxcode' => 'required|min:13|max:20',
            'users_company_th' => 'required|max:255',
            'users_company_en' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'CaptchaCode' => 'required|valid_captcha',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect('user/companyregister')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $user = User::companyregisteruser($input);

        $sendemailTo = $request->email;
        $sendemailFrom = env('MAIL_USERNAME');

        $data = array(
            'fullname' => $request->users_company_th
        );
        Mail::send('emails.register', $data, function ($message) use ($request, $sendemailTo, $sendemailFrom) {
            $message->from($sendemailFrom
                , "DGTFarm");
            $message->to($sendemailTo)
                ->subject("DGTFarm : " . trans('messages.email_subject_newregister'));

        });

        if ($user->id) {
            $arr_checked_user_standards = Input::get('users_standard');
            if (is_array($arr_checked_user_standards)) {
                foreach ($arr_checked_user_standards as $standard_id) {
                    UserStandard::create([
                        'user_id' => $user->id,
                        'standard_id' =>$standard_id
                    ]);
                }
            }
            return redirect('user/login')->with('status', 'User register successfully');
        } else {
            return redirect('user/register')->with('status', 'User not register. Please try again');
        }

    }
}
