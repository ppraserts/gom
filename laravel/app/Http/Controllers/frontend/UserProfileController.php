<?php

namespace App\Http\Controllers\frontend;

use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
  private $rules = [
      'name' => 'required',
      'email' => 'required|email',
  ];

  public function __construct()
  {
      //$this->middleware('auth');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();
      return view('frontend.userprofile',compact('item'));
  }

  public function update(Request $request)
  {
    $this->validate($request, $this->rules);

    $user = auth()->guard('user')->user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    $total = DB::select(DB::raw("select count(*) as cnt
                                 from admins
                                 where id <> ".$user->id."
                                 and email = '".$request->input('email')."' "));
    if($total[0]->cnt == 0){
      $user->save();

      return redirect()->route('userprofile.index')
        ->with('success', trans('messages.message_update_success'));
    }
    else {
      return redirect()->route('userprofile.index')->withErrors(trans('messages.message_email_inuse'));
    }
  }
}
