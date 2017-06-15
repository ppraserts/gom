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

      private $rules2 = [
         'contactusform_name' => 'required',
         'contactusform_surname' => 'required',
         'contactusform_email' => 'required|email',
         'contactusform_subject' => 'required',
         'contactusform_messagebox' => 'required',
         'contactusform_file' => 'max:3048',
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
        $ContactUsForm = new ContactUsForm();
        $ContactUsForm->id = 0;

        if($request->contactusform_file != "")
        {
          Validator::make($request->all(), $this->rules2)->validate();
          $uploadImage = $this->UploadImage($request);
          $ContactUsForm->contactusform_file = $uploadImage["imageName"];
        }
        else {
          Validator::make($request->all(), $this->rules)->validate();
        }

        $ContactUsForm->contactusform_name =  $request->contactusform_name;
        $ContactUsForm->contactusform_surname = $request->contactusform_surname;
        $ContactUsForm->contactusform_email = $request->contactusform_email;
        $ContactUsForm->contactusform_phone = $request->contactusform_phone;
        $ContactUsForm->contactusform_subject = $request->contactusform_subject;
        $ContactUsForm->contactusform_messagebox = $request->contactusform_messagebox;
        $ContactUsForm->save();

        $sendemailTo = env('MAIL_USERNAME');
        $data = array(
            'fullname' => $request->contactusform_name." ".$request->contactusform_surname,
            'email' => $request->contactusform_email,
            'phone' => $request->contactusform_phone,
            'title' => $request->contactusform_subject,
            'content' => $request->contactusform_messagebox,
        );
        sleep(1);
        Mail::send('emails.contactus', $data, function ($message) use($request, $sendemailTo, $ContactUsForm)
        {
            $message->from($request->contactusform_email
                    , $request->contactusform_name." ".$request->contactusform_surname);
            $message->to($sendemailTo)
                    ->subject("DGTFarm : ".$request->contactusform_subject);
            if($request->contactusform_file != "")
            {
              $message->attach(url($ContactUsForm->contactusform_file));
            }
        });
        return redirect()
                ->action('ContactusController@index')
                ->with('success',trans('messages.message_success_contactusform'));
      }

      private function UploadImage(Request $request)
      {
          $fileTimeStamp = time();
          $imageTempName = $request->file('contactusform_file')->getPathname();

          $imageName = $request->contactusform_file->getClientOriginalName();
          $request->contactusform_file->move(config('app.upload_mailfile').$fileTimeStamp."/", $imageName);
          $imageName = config('app.upload_mailfile').$fileTimeStamp."/".$imageName;

          return array('imageTempName'=> $imageTempName, 'imageName' => $imageName);
      }
  }
