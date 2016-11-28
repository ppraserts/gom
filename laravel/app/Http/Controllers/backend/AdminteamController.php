<?php

namespace App\Http\Controllers\backend;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\backend\Admin;

class AdminteamController extends Controller
{
    private $rules = [
       'name' => 'required',
       'email' => 'required|email'
    ];

    private $rules2 = [
       'name' => 'required',
       'email' => 'required|email',
       'password' => 'required|min:6'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $this->HasPermission();
        $search = \Request::get('search');
        $items = Admin::where('is_superadmin','=',0)
                    ->Where(function ($query) {
                       $search = \Request::get('search');
                       $query->where('name','like','%'.$search.'%')
                             ->orWhere('email','like','%'.$search.'%');
                    })
                    ->orderBy('name','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.adminteamindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $this->HasPermission();
        $data = array('mode' => 'create');
        $item = new Admin();
        return view('backend.adminteamedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        $this->HasPermission();
        Validator::make($request->all(), $this->rules2)->validate();

        $adminUpdate = new Admin();
        $adminUpdate->name = $request['name'];
        $adminUpdate->email = $request['email'];
        $adminUpdate->password = bcrypt($request['password']);
        $adminUpdate->allow_menu = $type_string = implode(',', $request['chkallow_menu']);
        $adminUpdate->save();


        return redirect()->route('adminteam.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $this->HasPermission();
        $data = array('mode' => 'edit');
        $item = Admin::find($id);
        return view('backend.adminteamedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->HasPermission();
        if($request['password']=="")
        {
          $this->validate($request, $this->rules);
          $adminUpdate = Admin::find($id);
          $adminUpdate->name = $request['name'];
          $adminUpdate->email = $request['email'];

          if(count($request['chkallow_menu']) > 0)
            $adminUpdate->allow_menu = $type_string = implode(',', $request['chkallow_menu']);

          $adminUpdate->save();
        }
        else
        {
          $this->validate($request, $this->rules2);
          $adminUpdate = Admin::find($id);
          $adminUpdate->name = $request['name'];
          $adminUpdate->email = $request['email'];
          $adminUpdate->password = bcrypt($request['password']);

          if(count($request['chkallow_menu']) > 0)
            $adminUpdate->allow_menu = $type_string = implode(',', $request['chkallow_menu']);

          $adminUpdate->save();
        }

        return redirect()->route('adminteam.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $this->HasPermission();
        Admin::find($id)->delete();
        return redirect()->route('adminteam.index')
                        ->with('success',trans('messages.message_delete_success'));
    }

    private function HasPermission()
    {
      $adminteam = auth()->guard('admin')->user();
      if(!$adminteam->is_superadmin)
      {
        return redirect()->action('backend\UserProfileController@index');
      }
    }
}
