<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;
use App\ProductRequest;
use App\ProductCategory;

class ProductsViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function show($id)
    {
        //$item = ProductRequest::find($id);
        $item = DB::select(DB::raw("select *
																	from product_requests i
																	join users u on i.users_id = u.id
																	where i.id = $id
																	"));
        $useritem = auth()->guard('user')->user();
        return view('frontend.productview', compact('item', 'useritem'));
    }
}
