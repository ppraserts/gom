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

        $productRequest = ProductRequest::join('users', 'users.id', '=','product_requests.users_id')
            ->select('users.*', 'users.id AS user_id' ,'product_requests.*')
            ->where('product_requests.id', $id)
            ->first();

        $user = auth()->guard('user')->user();
        return view('frontend.productview', compact('productRequest', 'user'));
    }
}
