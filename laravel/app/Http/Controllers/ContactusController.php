<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\Contactus;
use App\ContactUsForm;

class ContactusController extends Controller
{
      private $rules = [
         'contactusform_name' => 'required',
         'contactusform_surname' => 'required',
         'contactusform_email' => 'required|email',
         'contactusform_subject' => 'required',
         'contactusform_messagebox' => 'required',
         'CaptchaCode' => 'required|valid_captcha',
      ];
      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
      }

      public function index(Request $request)
      {
          $item = new ContactUsForm();
          $contactusItem = ContactUs::find(1);
          return view('contactus',compact('contactusItem','item'));
      }

      public function store(Request $request)
      {
        Validator::make($request->all(), $this->rules)->validate();
        ContactUsForm::create($request->all());

        $sendemailTo = env('MAIL_USERNAME');
        $data = array(
            'fullname' => $request->contactusform_name." ".$request->contactusform_surname,
            'email' => $request->contactusform_email,
            'phone' => $request->contactusform_phone,
            'title' => $request->contactusform_subject,
            'content' => $request->contactusform_messagebox,
        );
        Mail::send('emails.contactus', $data, function ($message) use($request, $sendemailTo)
        {
            $message->from($request->contactusform_email
                    , $request->contactusform_name." ".$request->contactusform_surname);
            $message->to($sendemailTo)
                    ->subject("Greenmart Online Market : ".$request->contactusform_subject);

        });
        return redirect()
                ->action('ContactusController@index')
                ->with('success',trans('messages.message_success_contactusform'));
      }
  }
